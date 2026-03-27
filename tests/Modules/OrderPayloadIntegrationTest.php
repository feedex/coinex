<?php

declare(strict_types=1);

namespace Feedex\Tests\Modules;

use Feedex\Coinex\v2\Modules\FuturesOrder;
use Feedex\Coinex\v2\Modules\SpotOrder;
use Feedex\Coinex\v2\Payload\FuturesOrderPayload;
use Feedex\Coinex\v2\Payload\SpotOrderPayload;
use Feedex\Tests\Support\SpyHttpClient;
use PHPUnit\Framework\TestCase;

final class OrderPayloadIntegrationTest extends TestCase
{
    public function testSpotOrderPayloadMethodUsesExpectedEndpoint(): void
    {
        $spy = new SpyHttpClient();
        $module = new SpotOrder($spy);

        $module->putOrderPayload(SpotOrderPayload::limit('BTCUSDT', 'buy', '0.1', '60000'));

        self::assertSame('/spot/order', $spy->lastCall()['path']);
        self::assertSame('POST', $spy->lastCall()['method']);
    }

    public function testFuturesOrderPayloadMethodUsesExpectedEndpoint(): void
    {
        $spy = new SpyHttpClient();
        $module = new FuturesOrder($spy);

        $module->putOrderPayload(FuturesOrderPayload::limit('BTCUSDT', 'buy', '1', '60000'));

        self::assertSame('/futures/order', $spy->lastCall()['path']);
        self::assertSame('POST', $spy->lastCall()['method']);
    }
}
