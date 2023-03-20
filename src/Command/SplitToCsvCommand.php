<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SplitToCsvCommand extends Command
{
    protected static $defaultName = 'app:split';

    protected function configure()
    {
        $this->addArgument('inputFile', InputArgument::REQUIRED,"Input File");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileOutputs = [];
        $file = $input->getArgument('inputFile');
        $output->writeln($file);
        $output->writeln(file_exists($file));
        $dir = dirname($file). '/retrysByServer';
        $output->writeln("Dir: $dir");
        $contents = file($file);
        foreach ($contents as $line) {
            if(str_starts_with($line, 'server_name') || strlen($line) < 1){
                continue;
            }

            $exploded = preg_split('/\s+/', $line);
            $fileOutputs[$exploded[0]][] = $exploded[1] . ',' . $exploded[2];
        }

        foreach ($fileOutputs as $outFile => $data) {
            $strOut = "";
            foreach ($data as $line) {
                $strOut .= $line . "\n";
            }

            file_put_contents($dir . DIRECTORY_SEPARATOR . $outFile . ".csv", $strOut);
        }
        $output->writeln('working');
        return Command::SUCCESS;
    }
}
