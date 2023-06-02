<?php

namespace App\Message;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Service\Attribute\Required;

#[AsMessageHandler]
class Test2MessageHandler
{
    private LoggerInterface $logger;

    public function __invoke(Test2Message $message): void
    {
        $name = $message->getName();
        throw new Exception("Could not handle: $name");
        $this->logger->info($name);
        echo __CLASS__ . ": " . $name . "\n";
    }

    #[Required]
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
