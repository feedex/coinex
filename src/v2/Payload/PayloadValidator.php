<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Payload;

use Feedex\Coinex\v2\Exceptions\InvalidPayloadException;

final class PayloadValidator
{
    /**
     * @param array<string, mixed> $payload
     * @param list<string> $required
     */
    public static function requireKeys(array $payload, array $required, string $context): void
    {
        foreach ($required as $key) {
            if (!array_key_exists($key, $payload) || $payload[$key] === '' || $payload[$key] === null) {
                throw new InvalidPayloadException(sprintf('%s payload missing required key: %s', $context, $key));
            }
        }
    }

    /**
     * @param list<array<string, mixed>> $payloads
     * @param list<string> $required
     */
    public static function requireKeysForBatch(array $payloads, array $required, string $context): void
    {
        if ($payloads === []) {
            throw new InvalidPayloadException(sprintf('%s batch payload cannot be empty.', $context));
        }

        foreach ($payloads as $index => $payload) {
            self::requireKeys($payload, $required, sprintf('%s[%d]', $context, $index));
        }
    }
}
