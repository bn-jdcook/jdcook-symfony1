<?php

namespace App\MailPoc\Command;

use App\Service\AwsService;
use App\Service\EmailAddressesService;
use Aws\SesV2\Exception\SesV2Exception;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SimpleEmailServiceCommand extends Command
{
    protected static $defaultName = 'app:ses';
    private MailerInterface $mailer;
    private AwsService $awsService;
    private EmailAddressesService $emailAddressesService;

    public function __construct(MailerInterface $mailer, AwsService $awsService, EmailAddressesService $emailAddressesService, string $name = null)
    {
        parent::__construct($name);
        $this->mailer = $mailer;
        $this->awsService = $awsService;
        $this->emailAddressesService = $emailAddressesService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $v2Client = $this->awsService->getSdk()->createSesV2();
        $fromAddress = $this->emailAddressesService->getFromAddress();
        $addresses = array_merge($this->emailAddressesService->getToEmails(), [
            $fromAddress,
            'foo@nowhere.net',
            'bouncetest@tribulant.com',
        ]);

        try {
            $output->writeln('Sending...');
            $subject = 'this is a test via AWS SES ';
            $msg = (new Email())
                ->from($fromAddress)
                ->returnPath($fromAddress)
                ->subject($subject)
                ->html("<h1>This is a test!!!!</h1>" . rand(1, 1000));
            $msg->getHeaders()->addTextHeader('X-Transport', 'ses');

            foreach ($addresses as $toAddress) {
                $output->writeln("Trying $toAddress...");
                $msg2 = clone $msg;
                $msg2->to($toAddress)->subject($subject . $toAddress);
                try {
                    $details = $v2Client->getSuppressedDestination(['EmailAddress' => $toAddress]);
                    $reason = $details->get("SuppressedDestination")["Reason"];
                    $output->writeln("Not sending $toAddress: $reason");
                    continue;
                } catch (SesV2Exception $e) {
                    if($e->getStatusCode() !== Response::HTTP_NOT_FOUND){
                        throw $e;
                    }
                }
                try {
                    $this->mailer->send($msg2);
                    $output->writeln("Sent $toAddress.");
                } catch (TransportExceptionInterface $e) {
                    $output->writeln($e->getMessage());
                }
            }

            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }
}
