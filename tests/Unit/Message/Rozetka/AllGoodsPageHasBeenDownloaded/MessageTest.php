<?php

declare(strict_types=1);

namespace App\Tests\Unit\Message\Rozetka\AllGoodsPageHasBeenDownloaded;

use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /**
     * @dataProvider rawDataProvider
     */
    public function testCreateFromArray($rawData): void
    {
        $message = \App\Message\Rozetka\AllGoodsPageHasBeenDownloaded\MessageFactory::create($rawData);

        self::assertInstanceOf(\App\Message\Rozetka\AllGoodsPageHasBeenDownloaded\Message::class, $message);

        self::assertEquals($message->getData(), $rawData);
    }

    public static function rawDataProvider(): \Generator
    {
        yield [
            'simple data' => [
                'username' => 'username',
                'page' => 100,
                'data' => ['some data' => 'in array'],
                'action_date' => '2023-10-22 20:37:10',
            ],
        ];
    }
}