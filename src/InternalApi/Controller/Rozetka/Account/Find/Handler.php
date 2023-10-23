<?php

declare(strict_types=1);

namespace App\InternalApi\Controller\Rozetka\Account\Find;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Handler implements \App\InternalApi\ControllerInterface
{
    use \App\InternalApi\RequestTrait;
    use \App\InternalApi\ResponseTrait;

    public function __construct(
        private readonly \App\Repository\Rozetka\AccountInterface $repositoryRozetkaAccount,
    ) {
    }

    public function process(Request $request): JsonResponse
    {
        $requestData = $this->parseJson($request->getContent());

        $account = $this->repositoryRozetkaAccount->findByUsername($requestData->get('username'));

        if ($account === null) {
            return $this->error(
                text: 'Rozetka account not found',
                httpStatus: Response::HTTP_NOT_FOUND
            );
        }

        return $this->success(
            [
                'id' => $account->getId(),
            ]
        );
    }
}
