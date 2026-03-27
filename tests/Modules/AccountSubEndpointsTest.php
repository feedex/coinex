<?php

declare(strict_types=1);

namespace Feedex\Tests\Modules;

use Feedex\Coinex\v2\Modules\AccountSub;
use Feedex\Tests\Support\SpyHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class AccountSubEndpointsTest extends TestCase
{
    /** @param array<string, mixed> $args */
    #[DataProvider('endpointProvider')]
    public function testEndpoints(string $methodName, array $args, string $httpMethod, string $path): void
    {
        $spy = new SpyHttpClient();
        $module = new AccountSub($spy);

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
        yield 'createSub' => ['createSub', ['sub_name' => 'test'], 'POST', '/account/subs'];
        yield 'listSub' => ['listSub', ['page' => 1], 'GET', '/account/subs'];
        yield 'getSubInfo' => ['getSubInfo', ['sub_uid' => '1'], 'GET', '/account/subs/info'];
        yield 'frozenSub' => ['frozenSub', ['sub_uid' => '1'], 'POST', '/account/subs/frozen'];
        yield 'cancelFrozenSub' => ['cancelFrozenSub', ['sub_uid' => '1'], 'POST', '/account/subs/unfrozen'];
        yield 'createSubApi' => ['createSubApi', ['sub_uid' => '1'], 'POST', '/account/subs/api'];
        yield 'listSubApi' => ['listSubApi', ['sub_uid' => '1'], 'GET', '/account/subs/api'];
        yield 'getSubApi' => ['getSubApi', ['api_id' => '1'], 'GET', '/account/subs/api-detail'];
        yield 'editSubApi' => ['editSubApi', ['api_id' => '1'], 'POST', '/account/subs/edit-api'];
        yield 'deleteSubApi' => ['deleteSubApi', ['api_id' => '1'], 'POST', '/account/subs/delete-api'];
        yield 'getSubBalance' => ['getSubBalance', ['sub_uid' => '1'], 'GET', '/account/subs/balance'];
        yield 'getSubSpotBalance' => ['getSubSpotBalance', ['sub_uid' => '1'], 'GET', '/account/subs/spot-balance'];
        yield 'subTransfer' => ['subTransfer', ['from' => '1'], 'POST', '/account/subs/transfer'];
        yield 'listSubTransferHistory' => ['listSubTransferHistory', ['sub_uid' => '1'], 'GET', '/account/subs/transfer-history'];
    }
}
