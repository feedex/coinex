<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Http;

final class Signer
{
    public static function sign(
        string $method,
        string $requestPath,
        string $body,
        int $timestamp,
        string $secretKey
    ): string {
        $payload = strtoupper($method) . $requestPath . $body . $timestamp;

        return strtolower(hash_hmac('sha256', $payload, $secretKey));
    }
}
