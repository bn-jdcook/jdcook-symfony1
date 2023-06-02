<?php
// src/MessageHandler/SmsNotificationHandler.php
namespace App\Message;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Service\Attribute\Required;

#[AsMessageHandler]
class TestMessageHandler
{
    private LoggerInterface $logger;

    public function __invoke(TestMessage $message): void
    {
        $name = $message->getName();
        $this->logger->info($name);
        echo __CLASS__ . ": " . $name;
    }

    #[Required]
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
