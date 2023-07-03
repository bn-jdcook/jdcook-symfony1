<?php

namespace App\GradientPoc\Command;

use App\GradientPoc\Service\GradientService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GradientCommand extends Command
{
    protected static $defaultName = 'app:grad';
    private GradientService $service;

    public function __construct(GradientService $service, string $name = null)
    {
        parent::__construct($name);
        $this->service = $service;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Start");
        var_dump($this->service->getVendor());
        $output->writeln("Accounts:");
        var_dump($this->service->getAccounts());
        $output->writeln("End");
        return self::SUCCESS;
    }

}
