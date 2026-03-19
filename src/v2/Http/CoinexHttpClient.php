<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Http;

use Feedex\Coinex\v2\Contracts\HttpClientInterface;
use Feedex\Coinex\v2\Exceptions\CoinexRequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class CoinexHttpClient implements HttpClientInterface
{
    private const API_VERSION = '/v2';

    public function __construct(
        private readonly string $accessId,
        private readonly string $secretKey,
        private readonly string $baseUrl = 'https://api.coinex.com',
        private readonly int $timeout = 60
    ) {
    }

    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     *
     * @throws CoinexRequestException
     */
    public function request(
        string $method,
        string $path,
        array $query = [],
        array $body = [],
        bool $authenticated = true
    ): array {
        $method = strtoupper($method);
        $queryString = http_build_query($query, '', '&', PHP_QUERY_RFC3986);
        $requestPath = self::API_VERSION . $path . ($queryString !== '' ? '?' . $queryString : '');

        $bodyJson = $body === []
            ? ''
            : json_encode($body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);

        $options = [
            'timeout' => $this->timeout,
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ];

        if ($query !== []) {
            $options['query'] = $query;
        }

        if ($bodyJson !== '') {
            $options['body'] = $bodyJson;
            $options['headers']['Content-Type'] = 'application/json';
        }

        if ($authenticated) {
            $timestamp = (int) round(microtime(true) * 1000);
            $options['headers']['X-COINEX-KEY'] = $this->accessId;
            $options['headers']['X-COINEX-TIMESTAMP'] = (string) $timestamp;
            $options['headers']['X-COINEX-SIGN'] = Signer::sign(
                $method,
                $requestPath,
                $bodyJson,
                $timestamp,
                $this->secretKey
            );
        }

        try {
            $client = new Client(['base_uri' => $this->baseUrl]);
            $response = $client->request($method, $requestPath, $options);
            $status = $response->getStatusCode();
            $rawBody = $response->getBody()->getContents();

            /** @var array<string, mixed> $decoded */
            $decoded = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);

            if ($status >= 400) {
                throw new CoinexRequestException('HTTP request failed.', $status, $decoded);
            }

            if (($decoded['code'] ?? 0) !== 0) {
                $message = (string) ($decoded['message'] ?? 'CoinEx API error.');
                throw new CoinexRequestException($message, $status, $decoded);
            }

            return $decoded;
        } catch (GuzzleException|JsonException $exception) {
            throw new CoinexRequestException($exception->getMessage(), 0, [], $exception);
        }
    }
}
