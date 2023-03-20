<?php

namespace App\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TestHttpClientsCommand extends Command
{
    protected static $defaultName = 'app:testclients';
    private HttpClientInterface $symfonyClient;
    private int $count = 250;
    private string $url = "https://dev4api.intronistest.com/v2/version";
    private Client $guzzleClient;

    public function __construct(HttpClientInterface $symfonyClient, string $name = null)
    {
        parent::__construct($name);
        $this->symfonyClient = $symfonyClient;
        $this->guzzleClient = new Client();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = microtime(true);

//        $this->runSymfony($output);
        $this->runSymfonyConcurrent($output);
        $this->runGuzzle($output);
        $this->runGuzzleConcurrent($output);



        $fullTime = round(microtime(true) - $start, 2);
        $output->writeln("Ran in: $fullTime");
        return Command::SUCCESS;
    }

    protected function runSymfony(OutputInterface $output): void
    {
        $start = microtime(true);
        $output->writeln("Starting Symfony HttpClient");

        for ($i = 0; $i < $this->count; $i++) {
            $res = $this->symfonyClient->request('GET', $this->url)->getStatusCode();
        }

        $time = microtime(true) - $start;
        $output->writeln("Symfony Requests ran in: ". round($time, 2));
    }

    protected function runSymfonyConcurrent(OutputInterface $output): void
    {
        $start = microtime(true);

        /** @var ResponseInterface[] $responses */
        $responses = [];
        $output->writeln("Starting Symfony HttpClient Concurrently");


        for ($i = 0; $i < $this->count; $i++) {
            $responses[] = $this->symfonyClient->request('GET', $this->url);
        }


        foreach ($responses as $k => $res){
            $code = $res->getStatusCode();
        }


        $time = microtime(true) - $start;
        $output->writeln("Symfony Concurrent Requests ran in: ". round($time, 2));
    }

    protected function runGuzzle(OutputInterface $output): void
    {
        $start = microtime(true);
        $output->writeln("Starting Guzzle Client");

        for ($i = 0; $i < $this->count; $i++) {
            $req = new Request('GET', $this->url);
            try {
                $res = $this->guzzleClient->send($req);
            } catch (GuzzleException $e) {
            }
        }

        $time = microtime(true) - $start;
        $output->writeln("Guzzle Requests ran in: ". round($time, 2));
    }

    protected function runGuzzleConcurrent(OutputInterface $output): void
    {
        $start = microtime(true);

        $requests = [];
        $output->writeln("Starting Guzzle HttpClient Concurrently");


        for ($i = 0; $i < $this->count; $i++) {
            $requests[] = new Request('GET', $this->url);
        }

        $pool = new Pool($this->guzzleClient, $requests);
        $rtn = $pool->promise()->wait();

        $time = microtime(true) - $start;
        $output->writeln("Guzzle Concurrent Requests ran in: ". round($time, 2));
    }
}
