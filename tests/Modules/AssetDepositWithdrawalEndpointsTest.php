<?php

declare(strict_types=1);

namespace Feedex\Tests\Modules;

use Feedex\Coinex\v2\Modules\AssetDepositWithdrawal;
use Feedex\Tests\Support\SpyHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class AssetDepositWithdrawalEndpointsTest extends TestCase
{
    /** @param array<string, mixed> $args */
    #[DataProvider('endpointProvider')]
    public function testEndpoints(string $methodName, array $args, string $httpMethod, string $path): void
    {
        $spy = new SpyHttpClient();
        $module = new AssetDepositWithdrawal($spy);

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
        yield 'listAssetsInfo' => ['listAssetsInfo', ['ccy' => 'USDT'], 'GET', '/assets/info'];
        yield 'getDepositAddress' => ['getDepositAddress', ['ccy' => 'USDT'], 'GET', '/assets/deposit-address'];
        yield 'updateDepositAddress' => ['updateDepositAddress', ['ccy' => 'USDT'], 'POST', '/assets/renewal-deposit-address'];
        yield 'getDepositWithdrawalConfig' => ['getDepositWithdrawalConfig', ['ccy' => 'USDT'], 'GET', '/assets/deposit-withdraw-config'];
        yield 'listAllDepositWithdrawalConfig' => ['listAllDepositWithdrawalConfig', [], 'GET', '/assets/all-deposit-withdraw-config'];
        yield 'listDepositHistory' => ['listDepositHistory', ['ccy' => 'USDT'], 'GET', '/assets/deposit-history'];
        yield 'listWithdrawalHistory' => ['listWithdrawalHistory', ['ccy' => 'USDT'], 'GET', '/assets/withdraw'];
        yield 'withdrawal' => ['withdrawal', ['ccy' => 'USDT'], 'POST', '/assets/withdraw'];
        yield 'cancelWithdrawal' => ['cancelWithdrawal', ['withdraw_id' => '1'], 'POST', '/assets/cancel-withdraw'];
    }
}
