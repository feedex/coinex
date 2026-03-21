<?php

declare(strict_types=1);

namespace Feedex\Tests\Modules;

use Feedex\Coinex\v2\Modules\SpotOrder;
use Feedex\Tests\Support\SpyHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class SpotOrderEndpointsTest extends TestCase
{
    /** @param array<string, mixed> $args */
    #[DataProvider('endpointProvider')]
    public function testEndpoints(string $methodName, array $args, string $httpMethod, string $path, bool $authenticated): void
    {
        $spy = new SpyHttpClient();
        $module = new SpotOrder($spy);

        $module->{$methodName}($args);

        self::assertSame([
            'method' => $httpMethod,
            'path' => $path,
            'query' => $httpMethod === 'GET' ? $args : [],
            'body' => $httpMethod === 'POST' ? $args : [],
            'authenticated' => $authenticated,
        ], $spy->lastCall());
    }

    /** @return iterable<string, array{string, array<string, mixed>, string, string, bool}> */
    public static function endpointProvider(): iterable
    {
        yield 'putOrder' => ['putOrder', ['market' => 'BTCUSDT'], 'POST', '/spot/order', true];
        yield 'putBatchOrder' => ['putBatchOrder', ['orders' => []], 'POST', '/spot/batch-order', true];
        yield 'putStopOrder' => ['putStopOrder', ['market' => 'BTCUSDT'], 'POST', '/spot/stop-order', true];
        yield 'putBatchStopOrder' => ['putBatchStopOrder', ['stop_orders' => []], 'POST', '/spot/batch-stop-order', true];
        yield 'editOrder' => ['editOrder', ['order_id' => 1], 'POST', '/spot/modify-order', true];
        yield 'editBatchOrder' => ['editBatchOrder', ['orders' => []], 'POST', '/spot/batch-modify-order', true];
        yield 'editStopOrder' => ['editStopOrder', ['stop_id' => 1], 'POST', '/spot/modify-stop-order', true];
        yield 'cancelOrder' => ['cancelOrder', ['order_id' => 1], 'POST', '/spot/cancel-order', true];
        yield 'cancelOrderByClientId' => ['cancelOrderByClientId', ['client_id' => 'abc'], 'POST', '/spot/cancel-order-by-client-id', true];
        yield 'cancelBatchOrder' => ['cancelBatchOrder', ['order_ids' => [1, 2]], 'POST', '/spot/cancel-batch-order', true];
        yield 'cancelAllOrder' => ['cancelAllOrder', ['market' => 'BTCUSDT'], 'POST', '/spot/cancel-all-order', true];
        yield 'cancelStopOrder' => ['cancelStopOrder', ['stop_id' => 1], 'POST', '/spot/cancel-stop-order', true];
        yield 'cancelStopOrderByClientId' => ['cancelStopOrderByClientId', ['client_id' => 'abc'], 'POST', '/spot/cancel-stop-order-by-client-id', true];
        yield 'cancelBatchStopOrder' => ['cancelBatchStopOrder', ['stop_ids' => [1]], 'POST', '/spot/cancel-batch-stop-order', true];
        yield 'getOrderStatus' => ['getOrderStatus', ['order_id' => 1], 'GET', '/spot/order-status', true];
        yield 'getBatchOrderStatus' => ['getBatchOrderStatus', ['order_ids' => '1,2'], 'GET', '/spot/batch-order-status', true];
        yield 'listPendingOrder' => ['listPendingOrder', ['market' => 'BTCUSDT'], 'GET', '/spot/pending-order', true];
        yield 'listFinishedOrder' => ['listFinishedOrder', ['market' => 'BTCUSDT'], 'GET', '/spot/finished-order', true];
        yield 'listPendingStopOrder' => ['listPendingStopOrder', ['market' => 'BTCUSDT'], 'GET', '/spot/pending-stop-order', true];
        yield 'listFinishedStopOrder' => ['listFinishedStopOrder', ['market' => 'BTCUSDT'], 'GET', '/spot/finished-stop-order', true];
    }
}
