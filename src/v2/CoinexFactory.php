<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2;

use Feedex\Contracts\ExchangeFactoryInterface;
use Feedex\Contracts\ExchangeInterface;
use InvalidArgumentException;

final class CoinexFactory implements ExchangeFactoryInterface
{
    public function exchangeId(): string
    {
        return 'coinex';
    }

    /**
     * @param array<string, mixed> $config
     */
    public function create(array $config): ExchangeInterface
    {
        $accessId = $config['access_id'] ?? null;
        $secretKey = $config['secret_key'] ?? null;

        if (!is_string($accessId) || $accessId === '') {
            throw new InvalidArgumentException('Missing required config key: access_id');
        }

        if (!is_string($secretKey) || $secretKey === '') {
            throw new InvalidArgumentException('Missing required config key: secret_key');
        }

        $baseUrl = isset($config['base_url']) && is_string($config['base_url'])
            ? $config['base_url']
            : 'https://api.coinex.com';

        $timeout = isset($config['timeout']) && is_int($config['timeout'])
            ? $config['timeout']
            : 60;

        return new Coinex($accessId, $secretKey, $baseUrl, $timeout);
    }
}
