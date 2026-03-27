<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Coinex\v2\Payload\FuturesOrderPayload;
use Feedex\Coinex\v2\Payload\PayloadValidator;
use Feedex\Contracts\Modules\FuturesOrderModuleInterface;

final class FuturesOrder extends Module implements FuturesOrderModuleInterface
{
    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['market'], 'futures.order');

        return $this->privatePost('/futures/order', $payload);
    }

    /**
     * @return array<string, mixed>
     */
    public function putOrderPayload(FuturesOrderPayload $payload): array
    {
        return $this->putOrder($payload->toArray());
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putBatchOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['orders'], 'futures.batch-order');

        return $this->privatePost('/futures/batch-order', $payload);
    }

    /**
     * @param list<FuturesOrderPayload> $orders
     * @return array<string, mixed>
     */
    public function putBatchOrderPayload(array $orders): array
    {
        $rows = array_map(static fn (FuturesOrderPayload $payload): array => $payload->toArray(), $orders);
        PayloadValidator::requireKeysForBatch($rows, ['market'], 'futures.batch-order.orders');

        return $this->putBatchOrder(['orders' => $rows]);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putStopOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['market'], 'futures.stop-order');

        return $this->privatePost('/futures/stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putBatchStopOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['stop_orders'], 'futures.batch-stop-order');

        return $this->privatePost('/futures/batch-stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function editOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['order_id'], 'futures.modify-order');

        return $this->privatePost('/futures/modify-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function editBatchOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['orders'], 'futures.batch-modify-order');

        return $this->privatePost('/futures/batch-modify-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function editStopOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['stop_id'], 'futures.modify-stop-order');

        return $this->privatePost('/futures/modify-stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['order_id'], 'futures.cancel-order');

        return $this->privatePost('/futures/cancel-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelOrderByClientId(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['client_id'], 'futures.cancel-order-by-client-id');

        return $this->privatePost('/futures/cancel-order-by-client-id', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelBatchOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['order_ids'], 'futures.cancel-batch-order');

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
        PayloadValidator::requireKeys($payload, ['stop_id'], 'futures.cancel-stop-order');

        return $this->privatePost('/futures/cancel-stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelStopOrderByClientId(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['client_id'], 'futures.cancel-stop-order-by-client-id');

        return $this->privatePost('/futures/cancel-stop-order-by-client-id', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelBatchStopOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['stop_ids'], 'futures.cancel-batch-stop-order');

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
        PayloadValidator::requireKeys($query, ['order_ids'], 'futures.batch-order-status');

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
