<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Exceptions;

use RuntimeException;

class CoinexRequestException extends RuntimeException
{
    /**
     * @param array<string, mixed> $response
     */
    public function __construct(
        string $message,
        private readonly int $httpStatus = 0,
        private readonly array $response = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $httpStatus, $previous);
    }

    public function httpStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * @return array<string, mixed>
     */
    public function response(): array
    {
        return $this->response;
    }
}
