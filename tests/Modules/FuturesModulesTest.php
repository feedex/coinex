<?php

declare(strict_types=1);

namespace Feedex\Tests\Modules;

use Feedex\Coinex\v2\Modules\FuturesMarket;
use Feedex\Coinex\v2\Modules\FuturesOrder;
use Feedex\Tests\Support\SpyHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class FuturesModulesTest extends TestCase
{
    /** @param array<string, mixed> $args */
    #[DataProvider('futuresMarketProvider')]
    public function testFuturesMarketEndpoints(string $methodName, array $args, string $path): void
    {
        $spy = new SpyHttpClient();
        $module = new FuturesMarket($spy);

        $module->{$methodName}($args);

        self::assertSame([
            'method' => 'GET',
            'path' => $path,
            'query' => $args,
            'body' => [],
            'authenticated' => false,
        ], $spy->lastCall());
    }

    /** @param array<string, mixed> $args */
    #[DataProvider('futuresOrderProvider')]
    public function testFuturesOrderEndpoints(string $methodName, array $args, string $httpMethod, string $path): void
    {
        $spy = new SpyHttpClient();
        $module = new FuturesOrder($spy);

        $module->{$methodName}($args);

        self::assertSame([
            'method' => $httpMethod,
            'path' => $path,
            'query' => $httpMethod === 'GET' ? $args : [],
            'body' => $httpMethod === 'POST' ? $args : [],
            'authenticated' => true,
        ], $spy->lastCall());
    }

    /** @return iterable<string, array{string, array<string, mixed>, string}> */
    public static function futuresMarketProvider(): iterable
    {
        yield 'listMarkets' => ['listMarkets', ['market' => 'BTCUSDT'], '/futures/market'];
        yield 'listMarketTicker' => ['listMarketTicker', ['market' => 'BTCUSDT'], '/futures/ticker'];
        yield 'listMarketDepth' => ['listMarketDepth', ['market' => 'BTCUSDT'], '/futures/depth'];
        yield 'listMarketDeals' => ['listMarketDeals', ['market' => 'BTCUSDT'], '/futures/deals'];
        yield 'listMarketKline' => ['listMarketKline', ['market' => 'BTCUSDT', 'period' => '1min'], '/futures/kline'];
        yield 'listMarketIndex' => ['listMarketIndex', ['market' => 'BTCUSDT'], '/futures/index'];
        yield 'listMarketFundingRate' => ['listMarketFundingRate', ['market' => 'BTCUSDT'], '/futures/funding-rate'];
        yield 'listMarketFundingRateHistory' => ['listMarketFundingRateHistory', ['market' => 'BTCUSDT'], '/futures/funding-rate-history'];
        yield 'listMarketBasisHistory' => ['listMarketBasisHistory', ['market' => 'BTCUSDT'], '/futures/basis-history'];
        yield 'listMarketLiquidationHistory' => ['listMarketLiquidationHistory', ['market' => 'BTCUSDT'], '/futures/liquidation-history'];
        yield 'listMarketPositionLevel' => ['listMarketPositionLevel', ['market' => 'BTCUSDT'], '/futures/position-level'];
        yield 'listMarketPremiumHistory' => ['listMarketPremiumHistory', ['market' => 'BTCUSDT'], '/futures/premium-index-history'];
    }

    /** @return iterable<string, array{string, array<string, mixed>, string, string}> */
    public static function futuresOrderProvider(): iterable
    {
        yield 'putOrder' => ['putOrder', ['market' => 'BTCUSDT'], 'POST', '/futures/order'];
        yield 'putBatchOrder' => ['putBatchOrder', ['orders' => []], 'POST', '/futures/batch-order'];
        yield 'putStopOrder' => ['putStopOrder', ['market' => 'BTCUSDT'], 'POST', '/futures/stop-order'];
        yield 'putBatchStopOrder' => ['putBatchStopOrder', ['stop_orders' => []], 'POST', '/futures/batch-stop-order'];
        yield 'editOrder' => ['editOrder', ['order_id' => 1], 'POST', '/futures/modify-order'];
        yield 'editBatchOrder' => ['editBatchOrder', ['orders' => []], 'POST', '/futures/batch-modify-order'];
        yield 'editStopOrder' => ['editStopOrder', ['stop_id' => 1], 'POST', '/futures/modify-stop-order'];
        yield 'cancelOrder' => ['cancelOrder', ['order_id' => 1], 'POST', '/futures/cancel-order'];
        yield 'cancelOrderByClientId' => ['cancelOrderByClientId', ['client_id' => 'abc'], 'POST', '/futures/cancel-order-by-client-id'];
        yield 'cancelBatchOrder' => ['cancelBatchOrder', ['order_ids' => [1, 2]], 'POST', '/futures/cancel-batch-order'];
        yield 'cancelAllOrder' => ['cancelAllOrder', ['market' => 'BTCUSDT'], 'POST', '/futures/cancel-all-order'];
        yield 'cancelStopOrder' => ['cancelStopOrder', ['stop_id' => 1], 'POST', '/futures/cancel-stop-order'];
        yield 'cancelStopOrderByClientId' => ['cancelStopOrderByClientId', ['client_id' => 'abc'], 'POST', '/futures/cancel-stop-order-by-client-id'];
        yield 'cancelBatchStopOrder' => ['cancelBatchStopOrder', ['stop_ids' => [1]], 'POST', '/futures/cancel-batch-stop-order'];
        yield 'getOrderStatus' => ['getOrderStatus', ['order_id' => 1], 'GET', '/futures/order-status'];
        yield 'getBatchOrderStatus' => ['getBatchOrderStatus', ['order_ids' => '1,2'], 'GET', '/futures/batch-order-status'];
        yield 'listPendingOrder' => ['listPendingOrder', ['market' => 'BTCUSDT'], 'GET', '/futures/pending-order'];
        yield 'listFinishedOrder' => ['listFinishedOrder', ['market' => 'BTCUSDT'], 'GET', '/futures/finished-order'];
        yield 'listPendingStopOrder' => ['listPendingStopOrder', ['market' => 'BTCUSDT'], 'GET', '/futures/pending-stop-order'];
        yield 'listFinishedStopOrder' => ['listFinishedStopOrder', ['market' => 'BTCUSDT'], 'GET', '/futures/finished-stop-order'];
    }
}
