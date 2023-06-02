<?php

namespace App\Message;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\Serializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class AzureServiceBusSerializer extends Serializer implements SerializerInterface
{
    /**
     * @inheritDoc
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        if (isset($encodedEnvelope['headers']['type'][0])) {
            $type = str_ireplace('"', '', str_ireplace('\\\\', '\\', $encodedEnvelope['headers']['type'][0]));
            $encodedEnvelope['headers']['type'] = $type;
        }

        return parent::decode($encodedEnvelope);
    }

    /**
     * @inheritDoc
     */
    public function encode(Envelope $envelope): array
    {
        $rtn = parent::encode($envelope);
        unset($rtn['headers']['X-Message-Stamp-Symfony\Component\Messenger\Stamp\BusNameStamp']);
        return $rtn;
    }
}
