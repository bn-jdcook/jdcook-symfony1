<?php

namespace App\Command;

use App\Message\Test2Message;
use App\Message\TestMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class TestMessageCommand extends Command
{
    protected static $defaultName = 'app:testmsg';

    public function __construct(private MessageBusInterface $messageBus, string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument("name");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument("name");
        $this->messageBus->dispatch(new TestMessage($name));
        $this->messageBus->dispatch(new Test2Message($name));
        $output->writeln("Message text: $name");
        return self::SUCCESS;
    }
}
