<?php

declare(strict_types=1);

namespace Feedex\Tests;

use Feedex\Coinex\v2\Http\Signer;
use PHPUnit\Framework\TestCase;

final class SignerTest extends TestCase
{
    public function testSignBuildsExpectedHmacSha256Signature(): void
    {
        $method = 'GET';
        $requestPath = '/v2/assets/spot/balance?ccy=USDT';
        $body = '';
        $timestamp = 1700000000000;
        $secret = 'test-secret';

        $expected = strtolower(hash_hmac('sha256', $method . $requestPath . $body . $timestamp, $secret));

        self::assertSame($expected, Signer::sign($method, $requestPath, $body, $timestamp, $secret));
    }
}
