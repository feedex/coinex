<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

final class FuturesOrder extends Module
{
    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putOrder(array $payload): array
    {
        return $this->privatePost('/futures/order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putBatchOrder(array $payload): array
    {
        return $this->privatePost('/futures/batch-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putStopOrder(array $payload): array
    {
        return $this->privatePost('/futures/stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putBatchStopOrder(array $payload): array
    {
        return $this->privatePost('/futures/batch-stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function editOrder(array $payload): array
    {
        return $this->privatePost('/futures/modify-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function editBatchOrder(array $payload): array
    {
        return $this->privatePost('/futures/batch-modify-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function editStopOrder(array $payload): array
    {
        return $this->privatePost('/futures/modify-stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelOrder(array $payload): array
    {
        return $this->privatePost('/futures/cancel-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelOrderByClientId(array $payload): array
    {
        return $this->privatePost('/futures/cancel-order-by-client-id', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelBatchOrder(array $payload): array
    {
        return $this->privatePost('/futures/cancel-batch-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelAllOrder(array $payload): array
    {
        return $this->privatePost('/futures/cancel-all-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelStopOrder(array $payload): array
    {
        return $this->privatePost('/futures/cancel-stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelStopOrderByClientId(array $payload): array
    {
        return $this->privatePost('/futures/cancel-stop-order-by-client-id', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelBatchStopOrder(array $payload): array
    {
        return $this->privatePost('/futures/cancel-batch-stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function getOrderStatus(array $query): array
    {
        return $this->privateGet('/futures/order-status', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function getBatchOrderStatus(array $query): array
    {
        return $this->privateGet('/futures/batch-order-status', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPendingOrder(array $query = []): array
    {
        return $this->privateGet('/futures/pending-order', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFinishedOrder(array $query = []): array
    {
        return $this->privateGet('/futures/finished-order', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPendingStopOrder(array $query = []): array
    {
        return $this->privateGet('/futures/pending-stop-order', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFinishedStopOrder(array $query = []): array
    {
        return $this->privateGet('/futures/finished-stop-order', $query);
    }
}
