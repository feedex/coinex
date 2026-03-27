<?php

declare(strict_types=1);

namespace Feedex\Tests\Payload;

use Feedex\Coinex\v2\Exceptions\InvalidPayloadException;
use Feedex\Coinex\v2\Payload\FuturesOrderPayload;
use Feedex\Coinex\v2\Payload\SpotOrderPayload;
use PHPUnit\Framework\TestCase;

final class OrderPayloadTest extends TestCase
{
    public function testSpotOrderLimitBuilderProducesPayload(): void
    {
        $payload = SpotOrderPayload::limit('BTCUSDT', 'buy', '0.1', '60000')->toArray();

        self::assertSame('BTCUSDT', $payload['market']);
        self::assertSame('limit', $payload['type']);
    }

    public function testFuturesOrderLimitBuilderProducesPayload(): void
    {
        $payload = FuturesOrderPayload::limit('BTCUSDT', 'buy', '1', '60000')->toArray();

        self::assertSame('BTCUSDT', $payload['market']);
        self::assertSame('limit', $payload['type']);
    }

    public function testSpotOrderPayloadValidationFailsWhenMarketMissing(): void
    {
        $this->expectException(InvalidPayloadException::class);

        SpotOrderPayload::fromArray(['side' => 'buy']);
    }

    public function testFuturesOrderPayloadValidationFailsWhenMarketMissing(): void
    {
        $this->expectException(InvalidPayloadException::class);

        FuturesOrderPayload::fromArray(['side' => 'buy']);
    }
}
