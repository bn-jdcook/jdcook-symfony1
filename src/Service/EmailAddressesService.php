<?php

namespace App\Service;

class EmailAddressesService
{

    private string $fromEmail;
    private string $toEmail;
    private string $ccEmail;
    private array $toEmails;

    public function __construct(string $fromEmail, string $toEmail, string $ccEmail, string $toEmails)
    {
        $this->fromEmail = $fromEmail;
        $this->toEmail = $toEmail;
        $this->ccEmail = $ccEmail;
        $this->toEmails = explode(',', $toEmails);
    }

    public function getFromAddress(): string
    {
        return $this->fromEmail;
    }

    public function getToAddress(): string
    {
        return $this->toEmail;
    }

    /**
     * @return string
     */
    public function getCcEmail(): string
    {
        return $this->ccEmail;
    }

    /**
     * @return string[]
     */
    public function getToEmails(): array
    {
        return $this->toEmails;
    }
}
