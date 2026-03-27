<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Coinex\v2\Payload\PayloadValidator;
use Feedex\Coinex\v2\Payload\SpotOrderPayload;
use Feedex\Contracts\Modules\SpotOrderModuleInterface;

final class SpotOrder extends Module implements SpotOrderModuleInterface
{
    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['market'], 'spot.order');

        return $this->privatePost('/spot/order', $payload);
    }

    /**
     * @return array<string, mixed>
     */
    public function putOrderPayload(SpotOrderPayload $payload): array
    {
        return $this->putOrder($payload->toArray());
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putBatchOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['orders'], 'spot.batch-order');

        return $this->privatePost('/spot/batch-order', $payload);
    }

    /**
     * @param list<SpotOrderPayload> $orders
     * @return array<string, mixed>
     */
    public function putBatchOrderPayload(array $orders): array
    {
        $rows = array_map(static fn (SpotOrderPayload $payload): array => $payload->toArray(), $orders);
        PayloadValidator::requireKeysForBatch($rows, ['market'], 'spot.batch-order.orders');

        return $this->putBatchOrder(['orders' => $rows]);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putStopOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['market'], 'spot.stop-order');

        return $this->privatePost('/spot/stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function putBatchStopOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['stop_orders'], 'spot.batch-stop-order');

        return $this->privatePost('/spot/batch-stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function editOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['order_id'], 'spot.modify-order');

        return $this->privatePost('/spot/modify-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function editBatchOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['orders'], 'spot.batch-modify-order');

        return $this->privatePost('/spot/batch-modify-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function editStopOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['stop_id'], 'spot.modify-stop-order');

        return $this->privatePost('/spot/modify-stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['order_id'], 'spot.cancel-order');

        return $this->privatePost('/spot/cancel-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelOrderByClientId(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['client_id'], 'spot.cancel-order-by-client-id');

        return $this->privatePost('/spot/cancel-order-by-client-id', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelBatchOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['order_ids'], 'spot.cancel-batch-order');

        return $this->privatePost('/spot/cancel-batch-order', $payload);
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
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelStopOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['stop_id'], 'spot.cancel-stop-order');

        return $this->privatePost('/spot/cancel-stop-order', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelStopOrderByClientId(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['client_id'], 'spot.cancel-stop-order-by-client-id');

        return $this->privatePost('/spot/cancel-stop-order-by-client-id', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelBatchStopOrder(array $payload): array
    {
        PayloadValidator::requireKeys($payload, ['stop_ids'], 'spot.cancel-batch-stop-order');

        return $this->privatePost('/spot/cancel-batch-stop-order', $payload);
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
    public function getBatchOrderStatus(array $query): array
    {
        PayloadValidator::requireKeys($query, ['order_ids'], 'spot.batch-order-status');

        return $this->privateGet('/spot/batch-order-status', $query);
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

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPendingStopOrder(array $query = []): array
    {
        return $this->privateGet('/spot/pending-stop-order', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFinishedStopOrder(array $query = []): array
    {
        return $this->privateGet('/spot/finished-stop-order', $query);
    }
}
