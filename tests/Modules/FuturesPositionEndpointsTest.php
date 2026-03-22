<?php

declare(strict_types=1);

namespace Feedex\Tests\Modules;

use Feedex\Coinex\v2\Modules\FuturesPosition;
use Feedex\Tests\Support\SpyHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class FuturesPositionEndpointsTest extends TestCase
{
    /** @param array<string, mixed> $args */
    #[DataProvider('endpointProvider')]
    public function testEndpoints(string $methodName, array $args, string $httpMethod, string $path): void
    {
        $spy = new SpyHttpClient();
        $module = new FuturesPosition($spy);

        $module->{$methodName}($args);

        self::assertSame([
            'method' => $httpMethod,
            'path' => $path,
            'query' => $httpMethod === 'GET' ? $args : [],
            'body' => $httpMethod === 'POST' ? $args : [],
            'authenticated' => true,
        ], $spy->lastCall());
    }

    /** @return iterable<string, array{string, array<string, mixed>, string, string}> */
    public static function endpointProvider(): iterable
    {
        yield 'closePosition' => ['closePosition', ['market' => 'BTCUSDT'], 'POST', '/futures/close-position'];
        yield 'adjustPositionMargin' => ['adjustPositionMargin', ['market' => 'BTCUSDT'], 'POST', '/futures/adjust-position-margin'];
        yield 'adjustPositionLeverage' => ['adjustPositionLeverage', ['market' => 'BTCUSDT'], 'POST', '/futures/adjust-position-leverage'];
        yield 'setPositionStopLoss' => ['setPositionStopLoss', ['market' => 'BTCUSDT'], 'POST', '/futures/set-position-stop-loss'];
        yield 'setPositionTakeProfit' => ['setPositionTakeProfit', ['market' => 'BTCUSDT'], 'POST', '/futures/set-position-take-profit'];
        yield 'modifyPositionStopLoss' => ['modifyPositionStopLoss', ['market' => 'BTCUSDT'], 'POST', '/futures/modify-position-stop-loss'];
        yield 'modifyPositionTakeProfit' => ['modifyPositionTakeProfit', ['market' => 'BTCUSDT'], 'POST', '/futures/modify-position-take-profit'];
        yield 'cancelPositionStopLoss' => ['cancelPositionStopLoss', ['market' => 'BTCUSDT'], 'POST', '/futures/cancel-position-stop-loss'];
        yield 'cancelPositionTakeProfit' => ['cancelPositionTakeProfit', ['market' => 'BTCUSDT'], 'POST', '/futures/cancel-position-take-profit'];

        yield 'listPendingPosition' => ['listPendingPosition', ['market' => 'BTCUSDT'], 'GET', '/futures/pending-position'];
        yield 'listFinishedPosition' => ['listFinishedPosition', ['market' => 'BTCUSDT'], 'GET', '/futures/finished-position'];
        yield 'listPositionMarginHistory' => ['listPositionMarginHistory', ['market' => 'BTCUSDT'], 'GET', '/futures/position-margin-history'];
        yield 'listPositionFundingHistory' => ['listPositionFundingHistory', ['market' => 'BTCUSDT'], 'GET', '/futures/position-funding-history'];
        yield 'listPositionAdlHistory' => ['listPositionAdlHistory', ['market' => 'BTCUSDT'], 'GET', '/futures/position-adl-history'];
        yield 'listPositionSettleHistory' => ['listPositionSettleHistory', ['market' => 'BTCUSDT'], 'GET', '/futures/position-settle-history'];
    }
}
