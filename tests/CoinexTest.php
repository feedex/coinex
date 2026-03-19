<?php

declare(strict_types=1);

namespace Feedex\Tests;

use Feedex\Coinex\v2\Coinex;
use Feedex\Coinex\v2\Modules\Account;
use Feedex\Coinex\v2\Modules\Asset;
use Feedex\Coinex\v2\Modules\Common;
use Feedex\Coinex\v2\Modules\SpotDeal;
use Feedex\Coinex\v2\Modules\SpotMarket;
use Feedex\Coinex\v2\Modules\SpotOrder;
use PHPUnit\Framework\TestCase;

final class CoinexTest extends TestCase
{
    public function testFactoryMethodsReturnExpectedModules(): void
    {
        $client = new Coinex('access-id', 'secret-key');

        self::assertInstanceOf(Common::class, $client->common());
        self::assertInstanceOf(Account::class, $client->account());
        self::assertInstanceOf(Asset::class, $client->asset());
        self::assertInstanceOf(Asset::class, $client->getAsset());
        self::assertInstanceOf(SpotMarket::class, $client->spotMarket());
        self::assertInstanceOf(SpotOrder::class, $client->spotOrder());
        self::assertInstanceOf(SpotDeal::class, $client->spotDeal());
    }
}
