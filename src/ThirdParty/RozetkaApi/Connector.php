<?php

declare(strict_types=1);

namespace App\ThirdParty\RozetkaApi;

class Connector implements ConnectorInterface
{
    private const API_HOST = 'api-seller.rozetka.com.ua';

    public function __construct(
        private readonly ClientFactory $clientFactory,
    ) {
    }

    public function single(
        Account $account,
        CommandInterface $command,
    ): \App\Kernel\ArrayWrapper {
        $request = $command->getRequest();
        $request = $this->completeRequest($request, $account);

        $client = $this->clientFactory->create($account);

        $response = $client->send($request);
        $responseBody = (array)json_decode((string)$response->getBody(), true);

        return new \App\Kernel\ArrayWrapper($responseBody);
    }

    private function completeRequest(
        \GuzzleHttp\Psr7\Request $request,
        Account $account,
    ): \Psr\Http\Message\RequestInterface {
        $uri = $request->getUri();
        if (empty($uri->getHost())) {
            $uri = $request->getUri()
                ->withHost(self::API_HOST)
                ->withScheme('https');
        }

        return $request->withUri($uri);
    }
}