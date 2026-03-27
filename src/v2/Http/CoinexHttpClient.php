<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Http;

use Feedex\Coinex\v2\Contracts\HttpClientInterface;
use Feedex\Coinex\v2\Exceptions\CoinexRateLimitException;
use Feedex\Coinex\v2\Exceptions\CoinexRequestException;
use Feedex\Coinex\v2\Exceptions\CoinexTransientException;
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
        private readonly int $timeout = 60,
        private readonly int $maxRetries = 0,
        private readonly int $retryDelayMs = 100,
        private readonly float $retryBackoffMultiplier = 2.0,
        private readonly ?Client $client = null
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
        $attempt = 0;
        $delayMs = max(0, $this->retryDelayMs);

        while (true) {
            try {
                return $this->requestOnce($method, $path, $query, $body, $authenticated);
            } catch (CoinexRequestException $exception) {
                if (!$this->shouldRetry($exception, $attempt)) {
                    throw $exception;
                }

                usleep($delayMs * 1000);
                $delayMs = (int) max(1, round($delayMs * $this->retryBackoffMultiplier));
                $attempt++;
            }
        }
    }

    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     *
     * @throws CoinexRequestException
     */
    private function requestOnce(
        string $method,
        string $path,
        array $query,
        array $body,
        bool $authenticated
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
            $client = $this->client ?? new Client(['base_uri' => $this->baseUrl]);
            $response = $client->request($method, $requestPath, $options);
            $status = $response->getStatusCode();
            $rawBody = $response->getBody()->getContents();

            /** @var array<string, mixed> $decoded */
            $decoded = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);

            if ($status >= 400) {
                throw ErrorMapper::from('HTTP request failed.', $status, $decoded);
            }

            if (($decoded['code'] ?? 0) !== 0) {
                $message = (string) ($decoded['message'] ?? 'CoinEx API error.');
                throw ErrorMapper::from($message, $status, $decoded);
            }

            return $decoded;
        } catch (GuzzleException|JsonException $exception) {
            throw ErrorMapper::from($exception->getMessage(), 0, [], $exception);
        }
    }

    private function shouldRetry(CoinexRequestException $exception, int $attempt): bool
    {
        if ($attempt >= $this->maxRetries) {
            return false;
        }

        return $exception instanceof CoinexTransientException
            || $exception instanceof CoinexRateLimitException
            || $exception->httpStatus() === 0;
    }
}
