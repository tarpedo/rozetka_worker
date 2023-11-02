<?php

declare(strict_types=1);

namespace App\InternalApi\Controller\Rozetka\Account\Create;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Handler implements \App\InternalApi\ControllerInterface
{
    use \App\InternalApi\RequestTrait;
    use \App\InternalApi\ResponseTrait;

    public function __construct(
        private readonly \App\Rozetka\Account\Service\Create $accountCreateService,
        private readonly \App\Repository\Rozetka\AccountInterface $repositoryRozetkaAccount,
    ) {
    }

    public function process(Request $request): JsonResponse
    {
        $requestData = $this->parseJson($request->getContent());

        $account = $this->repositoryRozetkaAccount->findByUsername(
            $requestData->get('username')
        );

        if ($account !== null) {
            return $this->error(
                text: 'Rozetka account is exist',
                httpStatus: Response::HTTP_BAD_REQUEST
            );
        }

        $account = $this->accountCreateService->process(
            $requestData->get('username'),
            $requestData->get('encoded_password')
        );

        if ($account === null) {
            return $this->error(
                text: 'Failed to create Rozetka account',
            );
        }

        return $this->success(
            [
                'id' => $account->getId(),
            ]
        );
    }
}
