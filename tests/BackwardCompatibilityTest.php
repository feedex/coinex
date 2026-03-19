<?php

declare(strict_types=1);

namespace Feedex\Tests;

use Feedex\Coinex\v2\Asset as LegacyAsset;
use Feedex\Coinex\v2\Request as LegacyRequest;
use Feedex\Coinex\v2\Http\CoinexHttpClient;
use PHPUnit\Framework\TestCase;

final class BackwardCompatibilityTest extends TestCase
{
    public function testLegacyClassesStillResolvable(): void
    {
        $asset = new LegacyAsset('access-id', 'secret-key');
        $request = new LegacyRequest('access-id', 'secret-key');

        self::assertInstanceOf(LegacyAsset::class, $asset);
        self::assertInstanceOf(CoinexHttpClient::class, $request);
    }
}
