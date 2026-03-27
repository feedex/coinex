<?php

declare(strict_types=1);

namespace Feedex\Tests\Http;

use Feedex\Coinex\v2\Exceptions\CoinexAuthenticationException;
use Feedex\Coinex\v2\Exceptions\CoinexRateLimitException;
use Feedex\Coinex\v2\Exceptions\CoinexRequestException;
use Feedex\Coinex\v2\Exceptions\CoinexTransientException;
use Feedex\Coinex\v2\Exceptions\CoinexValidationException;
use Feedex\Coinex\v2\Http\ErrorMapper;
use PHPUnit\Framework\TestCase;

final class ErrorMapperTest extends TestCase
{
    public function testMapsAuthenticationError(): void
    {
        $exception = ErrorMapper::from('invalid api key', 401);

        self::assertInstanceOf(CoinexAuthenticationException::class, $exception);
    }

    public function testMapsRateLimitError(): void
    {
        $exception = ErrorMapper::from('rate limit exceeded', 429);

        self::assertInstanceOf(CoinexRateLimitException::class, $exception);
    }

    public function testMapsValidationError(): void
    {
        $exception = ErrorMapper::from('invalid parameter', 400);

        self::assertInstanceOf(CoinexValidationException::class, $exception);
    }

    public function testMapsTransientError(): void
    {
        $exception = ErrorMapper::from('server error', 503);

        self::assertInstanceOf(CoinexTransientException::class, $exception);
    }

    public function testFallsBackToGenericRequestException(): void
    {
        $exception = ErrorMapper::from('unknown', 418);

        self::assertInstanceOf(CoinexRequestException::class, $exception);
    }
}
