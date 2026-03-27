<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Http;

use Feedex\Coinex\v2\Exceptions\CoinexAuthenticationException;
use Feedex\Coinex\v2\Exceptions\CoinexRateLimitException;
use Feedex\Coinex\v2\Exceptions\CoinexRequestException;
use Feedex\Coinex\v2\Exceptions\CoinexTransientException;
use Feedex\Coinex\v2\Exceptions\CoinexValidationException;

final class ErrorMapper
{
    /**
     * @param array<string, mixed> $response
     */
    public static function from(string $message, int $httpStatus, array $response = [], ?\Throwable $previous = null): CoinexRequestException
    {
        $normalized = strtolower($message);

        if ($httpStatus === 429 || str_contains($normalized, 'rate limit') || str_contains($normalized, 'too many requests')) {
            return new CoinexRateLimitException($message, $httpStatus, $response, $previous);
        }

        if (in_array($httpStatus, [401, 403], true)
            || str_contains($normalized, 'auth')
            || str_contains($normalized, 'signature')
            || str_contains($normalized, 'api key')) {
            return new CoinexAuthenticationException($message, $httpStatus, $response, $previous);
        }

        if ($httpStatus >= 500 || str_contains($normalized, 'timeout') || str_contains($normalized, 'temporar')) {
            return new CoinexTransientException($message, $httpStatus, $response, $previous);
        }

        if ($httpStatus === 400
            || str_contains($normalized, 'invalid')
            || str_contains($normalized, 'parameter')
            || str_contains($normalized, 'required')) {
            return new CoinexValidationException($message, $httpStatus, $response, $previous);
        }

        return new CoinexRequestException($message, $httpStatus, $response, $previous);
    }
}
