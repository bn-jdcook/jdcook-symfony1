<?php

namespace App\GradientPoc\Service;

use App\GradientPoc\Dto\AccountDto;
use App\GradientPoc\Dto\VendorDto;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GradientService
{

    private HttpClientInterface $client;
    private DenormalizerInterface $denormalizer;

    public function __construct(
        HttpClientInterface   $gradientClient,
        DenormalizerInterface $denormalizer
    )
    {
        $this->client = $gradientClient;
        $this->denormalizer = $denormalizer;
    }

    public function getVendor()
    {
        $res = $this->request('GET', '');
        $data = $res['data'];
        return $this->denormalizer->denormalize($data, VendorDto::class);
    }

    private function request(string $method, string $uri, array $options = [])
    {
        return $this->client->request($method, "/api/vendor-api" . $uri, $options)->toArray();
    }

    public function getAccounts()
    {
        $res = $this->request('GET', '/organization/accounts');
        return $this->denormalizer->denormalize($res, AccountDto::class . '[]');
    }
}
