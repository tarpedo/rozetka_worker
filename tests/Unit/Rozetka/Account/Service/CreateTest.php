<?php

namespace App\Tests\Unit\Rozetka\Account\Service;

use App\Entity\Rozetka\Account;
use App\Entity\Rozetka\Account\MarketInfo;
use App\Entity\Rozetka\Account\SellerInfo;
use App\Kernel\ArrayWrapper;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testProcessWithFailedFetchData(): void
    {
        $repositoryStub = $this->createStub(\App\Repository\Rozetka\AccountInterface::class);
        $eventDispatcherStub = $this->createStub(\Psr\EventDispatcher\EventDispatcherInterface::class);

        $credentialsRetrieveStub = $this->createStub(\App\ThirdParty\RozetkaApi\Service\CredentialsRetrieve::class);
        $credentialsRetrieveStub->method('process')->willReturn(
            new ArrayWrapper([
                'success' => false,
            ])
        );

        $accountCreate = new \App\Rozetka\Account\Service\Create(
            $repositoryStub,
            $credentialsRetrieveStub,
            $eventDispatcherStub,
        );

        $this->assertTrue($accountCreate->process('username', 'encodedPassword') === null);
    }

    public function testProcessUpdateExistsAccount(): void
    {
        $eventDispatcherStub = $this->createMock(\Psr\EventDispatcher\EventDispatcherInterface::class);
        $eventDispatcherStub->expects($this->never())->method('dispatch');

        $existAccount = new Account(
            'username',
            'encodedPasswordOld',
            new SellerInfo('fio', 'email'),
            new MarketInfo(1, 'title')
        );

        $repositoryStub = $this->createMock(\App\Repository\Rozetka\AccountInterface::class);
        $repositoryStub->expects($this->once())->method('findByUsername')->willReturn($existAccount);
        $repositoryStub->expects($this->once())->method('saveAll');

        $credentialsRetrieveStub = $this->createStub(\App\ThirdParty\RozetkaApi\Service\CredentialsRetrieve::class);
        $credentialsRetrieveStub->method('process')->willReturn(
            new ArrayWrapper([
                'success' => true,
                'content' => [
                    'seller' => [
                        'fio' => 'fio_new',
                        'email' => 'email_new',
                    ],
                    'market' => [
                        'id' => 3,
                        'title' => 'title_new',
                    ],
                ],
            ])
        );

        $accountCreate = new \App\Rozetka\Account\Service\Create(
            $repositoryStub,
            $credentialsRetrieveStub,
            $eventDispatcherStub,
        );

        $account = $accountCreate->process('username', 'encodedPasswordNew');

        $this->assertInstanceOf(\App\Entity\Rozetka\Account::class, $account);
        $this->assertEquals('encodedPasswordNew', $account->getPassword());
        $this->assertEquals('fio_new', $account->getSellerInfo()->getFio());
        $this->assertEquals('email_new', $account->getSellerInfo()->getEmail());
        $this->assertEquals(3, $account->getMarketInfo()->getId());
        $this->assertEquals('title_new', $account->getMarketInfo()->getTitle());
    }

    public function testProcessCreateAccount(): void
    {
        $eventDispatcherStub = $this->createMock(\Psr\EventDispatcher\EventDispatcherInterface::class);
        $eventDispatcherStub->expects($this->once())->method('dispatch');

        $repositoryStub = $this->createMock(\App\Repository\Rozetka\AccountInterface::class);
        $repositoryStub->expects($this->once())->method('findByUsername')->willReturn(null);
        $repositoryStub->expects($this->once())->method('create');

        $credentialsRetrieveStub = $this->createStub(\App\ThirdParty\RozetkaApi\Service\CredentialsRetrieve::class);
        $credentialsRetrieveStub->method('process')->willReturn(
            new ArrayWrapper([
                'success' => true,
                'content' => [
                    'seller' => [
                        'fio' => 'fio_new',
                        'email' => 'email_new',
                    ],
                    'market' => [
                        'id' => 3,
                        'title' => 'title_new',
                    ],
                ],
            ])
        );

        $accountCreate = new \App\Rozetka\Account\Service\Create(
            $repositoryStub,
            $credentialsRetrieveStub,
            $eventDispatcherStub,
        );

        $account = $accountCreate->process('username', 'encodedPasswordNew');

        $this->assertInstanceOf(\App\Entity\Rozetka\Account::class, $account);
        $this->assertEquals('encodedPasswordNew', $account->getPassword());
        $this->assertEquals('fio_new', $account->getSellerInfo()->getFio());
        $this->assertEquals('email_new', $account->getSellerInfo()->getEmail());
        $this->assertEquals(3, $account->getMarketInfo()->getId());
        $this->assertEquals('title_new', $account->getMarketInfo()->getTitle());
    }
}