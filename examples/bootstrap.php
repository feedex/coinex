<?php

declare(strict_types=1);

use Feedex\Coinex\v2\CoinexFactory;
use Feedex\Feedex;

require dirname(__DIR__) . '/vendor/autoload.php';

if (!function_exists('coinex_config')) {
    /**
     * @return array<string, mixed>
     */
    function coinex_config(): array
    {
        $accessId = getenv('COINEX_ACCESS_ID');
        $secretKey = getenv('COINEX_SECRET_KEY');

        if (!is_string($accessId) || $accessId === '' || !is_string($secretKey) || $secretKey === '') {
            throw new RuntimeException('Set COINEX_ACCESS_ID and COINEX_SECRET_KEY environment variables first.');
        }

        $config = [
            'access_id' => $accessId,
            'secret_key' => $secretKey,
        ];

        $baseUrl = getenv('COINEX_BASE_URL');
        if (is_string($baseUrl) && $baseUrl !== '') {
            $config['base_url'] = $baseUrl;
        }

        $timeout = getenv('COINEX_TIMEOUT');
        if (is_string($timeout) && ctype_digit($timeout)) {
            $config['timeout'] = (int) $timeout;
        }

        return $config;
    }
}

if (!function_exists('coinex_client')) {
    function coinex_client(): \Feedex\Coinex\v2\Coinex
    {
        $feedex = (new Feedex())->register(new CoinexFactory());

        /** @var \Feedex\Coinex\v2\Coinex $exchange */
        $exchange = $feedex->exchange('coinex', coinex_config());

        return $exchange;
    }
}

if (!function_exists('coinex_execute_enabled')) {
    function coinex_execute_enabled(): bool
    {
        return getenv('COINEX_EXECUTE') === '1';
    }
}
