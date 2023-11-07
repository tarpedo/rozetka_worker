<?php

declare(strict_types=1);

namespace App\PrivateApi\Controller\Rozetka\Account\Find;

use App\PrivateApi\EventSubscriber\Attribute;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Handler implements \App\PrivateApi\ControllerInterface
{
    use \App\PrivateApi\RequestTrait;
    use \App\PrivateApi\ResponseTrait;

    public function __construct(
        private readonly \App\Repository\Rozetka\AccountInterface $repositoryRozetkaAccount,
    ) {
    }

    #[Attribute\Authentication]
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
