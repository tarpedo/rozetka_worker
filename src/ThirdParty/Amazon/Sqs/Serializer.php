<?php

declare(strict_types=1);

namespace App\ThirdParty\Amazon\Sqs;

use App\Amazon\Sqs\Symfony;
use Symfony\Component\Messenger\Envelope;

class Serializer implements \Symfony\Component\Messenger\Transport\Serialization\SerializerInterface
{
    public function __construct(
        private readonly \App\ThirdParty\Amazon\Sqs\MessageResolver $messageResolver,
    ) {
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        $rawData = json_decode($encodedEnvelope['body'], true, flags: JSON_THROW_ON_ERROR);

        $message = $this->messageResolver->resolve(
            $rawData['name'] ?? \App\ThirdParty\Amazon\Sqs\Message\NotValid::NAME,
            $encodedEnvelope['data'] ?? $encodedEnvelope,
        );

        return new Envelope($message);
    }

    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();
        if (!$message instanceof \App\ThirdParty\Amazon\Sqs\MessageInterface) {
            throw new \LogicException('Message not valid');
        }

        if ($message instanceof \App\ThirdParty\Amazon\Sqs\Message\NotValid) {
            throw new \LogicException('Unable encode NotValid message');
        }

        return [
            'body' => json_encode([
                'name' => $message->getName(),
                'data' => $message->getData(),
            ]),
        ];
    }
}