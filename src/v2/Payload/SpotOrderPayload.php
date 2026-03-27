<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Payload;

final class SpotOrderPayload
{
    /**
     * @param array<string, mixed> $data
     */
    private function __construct(private readonly array $data)
    {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        PayloadValidator::requireKeys($payload, ['market'], 'spot.order');

        return new self($payload);
    }

    /**
     * @param array<string, mixed> $extra
     */
    public static function limit(string $market, string $side, string $amount, string $price, array $extra = []): self
    {
        $payload = array_merge([
            'market' => $market,
            'market_type' => 'SPOT',
            'type' => 'limit',
            'side' => $side,
            'amount' => $amount,
            'price' => $price,
        ], $extra);

        return self::fromArray($payload);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
