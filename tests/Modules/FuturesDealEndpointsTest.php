<?php

declare(strict_types=1);

namespace Feedex\Tests\Modules;

use Feedex\Coinex\v2\Modules\FuturesDeal;
use Feedex\Tests\Support\SpyHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class FuturesDealEndpointsTest extends TestCase
{
    /** @param array<string, mixed> $args */
    #[DataProvider('endpointProvider')]
    public function testEndpoints(string $methodName, array $args, string $path): void
    {
        $spy = new SpyHttpClient();
        $module = new FuturesDeal($spy);

        $module->{$methodName}($args);

        self::assertSame([
            'method' => 'GET',
            'path' => $path,
            'query' => $args,
            'body' => [],
            'authenticated' => true,
        ], $spy->lastCall());
    }

    /** @return iterable<string, array{string, array<string, mixed>, string}> */
    public static function endpointProvider(): iterable
    {
        yield 'listUserDeals' => ['listUserDeals', ['market' => 'BTCUSDT'], '/futures/user-deals'];
        yield 'listUserOrderDeals' => ['listUserOrderDeals', ['market' => 'BTCUSDT', 'order_id' => '1'], '/futures/order-deals'];
    }
}
