<?php

namespace App\MailPoc\Command;

use App\Service\EmailAddressesService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendGridCommand extends Command
{
    protected static $defaultName = 'app:sendgrid';
    /**
     * @var MailerInterface
     */
    private $mailer;
    private EmailAddressesService $emailAddressesService;

    public function __construct(MailerInterface $mailer, EmailAddressesService $emailAddressesService, string $name = null)
    {
        parent::__construct($name);
        $this->mailer = $mailer;
        $this->emailAddressesService = $emailAddressesService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Sending...');
        $msg = (new Email())
            ->from($this->emailAddressesService->getFromAddress())
            ->to($this->emailAddressesService->getToAddress())
            ->cc($this->emailAddressesService->getCcEmail())
            ->subject('this is a test via sendgrid')
            ->html("<h1>This is a test!!!!</h1>");
        $this->mailer->send($msg);
        $output->writeln('Sent.');
        return Command::SUCCESS;
    }
}
