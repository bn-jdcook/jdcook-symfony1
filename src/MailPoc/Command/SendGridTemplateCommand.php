<?php

namespace App\MailPoc\Command;

use App\Service\EmailAddressesService;
use Exception;
use SendGrid;
use SendGrid\Mail\Mail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendGridTemplateCommand extends Command
{
    protected static $defaultName = 'app:sendtemplate';
    private SendGrid $mailer;
    private EmailAddressesService $emailAddressesService;

    public function __construct(string $apiKey, EmailAddressesService $emailAddressesService, string $name = null)
    {
        parent::__construct($name);
        $this->mailer = new SendGrid($apiKey);
        $this->emailAddressesService = $emailAddressesService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rand = rand(1, 1000);
        $substitutions = ['subject' => 'This is a Test Subject!!!', 'name' => 'Andrew'. $rand];
        $output->writeln("Sending $rand...");
        $email = new Mail();
        $email->setFrom(
            $this->emailAddressesService->getFromAddress(),
            'Example Recipient'
        );

// cc and bcc does not work with the library
//        $email->addCc(
//            $this->emailAddressesService->getCcEmail(),
//            'Example Sender2',
//            $substitutions
//        );
        $email->addTo(
            $this->emailAddressesService->getToAddress(),
            'Example Sender',
            $substitutions
        );
        $email->setTemplateId('d-f9480039a4bf43ff9009187c93900dc2');
        try {
            $response = $this->mailer->send($email);
        } catch (Exception $e) {
            $output->writeln('Caught exception: '. $e->getMessage());
            $output->writeln('Failed.');
            return Command::FAILURE;
        }
        $output->writeln('Sent.');
        return ($response->statusCode() === 202)? Command::SUCCESS : Command::FAILURE;
    }
}
