<?php

namespace App\Service;

use App\Message\Test2Message;
use App\Message\TestMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class MessageService
{

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(object $message, array $stamps = [])
    {
        $name = $message->getName();
        $this->messageBus->dispatch(new TestMessage($name));
        $this->messageBus->dispatch(new Test2Message($name));
    }
}
