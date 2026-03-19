<?php

declare(strict_types=1);

namespace Feedex\Tests;

use Feedex\Coinex\v2\Coinex;
use Feedex\Coinex\v2\CoinexFactory;
use Feedex\Feedex;
use PHPUnit\Framework\TestCase;

final class CoinexFactoryTest extends TestCase
{
    public function testFactoryCreatesCoinexViaCoreRegistry(): void
    {
        $feedex = (new Feedex())->register(new CoinexFactory());

        $exchange = $feedex->exchange('coinex', [
            'access_id' => 'access-id',
            'secret_key' => 'secret-key',
        ]);

        self::assertInstanceOf(Coinex::class, $exchange);
    }
}
