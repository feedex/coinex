<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\SpotOrderModuleInterface;

final class SpotOrder extends Module implements SpotOrderModuleInterface
{
    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putOrder(array $payload): array
    {
        return $this->privatePost('/spot/order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelOrder(array $payload): array
    {
        return $this->privatePost('/spot/cancel-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelAllOrder(array $payload): array
    {
        return $this->privatePost('/spot/cancel-all-order', $payload);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function getOrderStatus(array $query): array
    {
        return $this->privateGet('/spot/order-status', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPendingOrder(array $query = []): array
    {
        return $this->privateGet('/spot/pending-order', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFinishedOrder(array $query = []): array
    {
        return $this->privateGet('/spot/finished-order', $query);
    }
}
