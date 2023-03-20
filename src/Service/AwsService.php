<?php

namespace App\Service;

use Aws\Credentials\Credentials;
use Aws\Sdk;

class AwsService
{
    private string $awsRegion;
    private string $awsKey;
    private string $awsSecret;

    public function __construct(string $awsRegion, string $awsKey, string $awsSecret)
    {
        $this->awsRegion = $awsRegion;
        $this->awsKey = $awsKey;
        $this->awsSecret = urldecode($awsSecret);
    }

    public function getSdk(): Sdk{
        $credentials = new Credentials($this->awsKey, $this->awsSecret);

        // The same options that can be provided to a specific client constructor can also be supplied to the Aws\Sdk class.
        // Use the us-west-2 region and latest version of each client.
        $sharedConfig = [
            'region' => $this->awsRegion,
            'version' => 'latest',
            'credentials' => $credentials
        ];

        // Create an SDK class used to share configuration across clients.
        return new Sdk($sharedConfig);
    }
}
