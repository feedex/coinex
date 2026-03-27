<?php

declare(strict_types=1);

namespace Feedex\Tests\Modules;

use Feedex\Coinex\v2\Modules\AssetLoan;
use Feedex\Tests\Support\SpyHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class AssetLoanEndpointsTest extends TestCase
{
    /** @param array<string, mixed> $args */
    #[DataProvider('endpointProvider')]
    public function testEndpoints(string $methodName, array $args, string $httpMethod, string $path): void
    {
        $spy = new SpyHttpClient();
        $module = new AssetLoan($spy);

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
        yield 'marginBorrow' => ['marginBorrow', ['ccy' => 'USDT'], 'POST', '/assets/margin/borrow'];
        yield 'marginRepay' => ['marginRepay', ['ccy' => 'USDT'], 'POST', '/assets/margin/repay'];
        yield 'listMarginBorrowHistory' => ['listMarginBorrowHistory', ['ccy' => 'USDT'], 'GET', '/assets/margin/borrow-history'];
        yield 'listMarginInterestLimit' => ['listMarginInterestLimit', ['ccy' => 'USDT'], 'GET', '/assets/margin/interest-limit'];
    }
}
