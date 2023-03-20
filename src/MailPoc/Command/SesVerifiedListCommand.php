<?php

namespace App\MailPoc\Command;

use App\Service\AwsService;
use App\Service\EmailAddressesService;
use Aws\Credentials\CredentialProvider;
use Aws\Credentials\Credentials;
use Aws\Sdk;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SesVerifiedListCommand extends Command
{
    protected static $defaultName = 'app:ses:list';
    private string $awsRegion;
    private string $awsKey;
    private string $awsSecret;
    private AwsService $awsService;
    private EmailAddressesService $emailAddressesService;

    public function __construct(AwsService $awsService, EmailAddressesService $emailAddressesService, string $name = null)
    {
        parent::__construct($name);
        $this->awsService = $awsService;
        $this->emailAddressesService = $emailAddressesService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Starting...");
        $client = $this->awsService->getSdk()->createSes();
        $var = $this->emailAddressesService->getToEmails();
        $results = $client->getIdentityVerificationAttributes([
            'Identities' => $var
        ])->get('VerificationAttributes');

        foreach ($var as $email) {
            $status = array_key_exists($email, $results) ? $results[$email]['VerificationStatus'] : "False";
            $output->writeln("$email: $status");
        }

        $random = rand(1, 1000);
//        $result = $client->createCustomVerificationEmailTemplate([
//            'FailureRedirectionURL' => 'https://example.com/failure', // REQUIRED
//            'FromEmailAddress' => $this->emailAddressesService->getFromAddress(), // REQUIRED
//            'SuccessRedirectionURL' => 'https://example.com/success', // REQUIRED
//            'TemplateContent' => 'This is the content', // REQUIRED
//            'TemplateName' => "templateName$random", // REQUIRED
//            'TemplateSubject' => "templateName$random subject", // REQUIRED
//        ]);


        $output->writeln('Templates');
        $templates = $client->listCustomVerificationEmailTemplates()->get('CustomVerificationEmailTemplates');
        foreach ($templates as $template) {
            $output->writeln($template['TemplateName']);
        }
        $output->writeln('---');

        $template = $client->getCustomVerificationEmailTemplate(['TemplateName' => $templates[0]['TemplateName']])->toArray();
        $output->writeln('Single template: ' . $template['TemplateName']);

        $result = $client->sendCustomVerificationEmail([
            'EmailAddress' => 'jdcook@intronis.com', // REQUIRED
            'TemplateName' => $templates[0]['TemplateName'], // REQUIRED
        ]);

var_dump($result->get('@metadata')['statusCode']);
        return Command::SUCCESS;
    }

}
