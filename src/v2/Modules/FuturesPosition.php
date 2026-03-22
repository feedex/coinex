<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\FuturesPositionModuleInterface;

final class FuturesPosition extends Module implements FuturesPositionModuleInterface
{
    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function closePosition(array $payload): array
    {
        return $this->privatePost('/futures/close-position', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function adjustPositionMargin(array $payload): array
    {
        return $this->privatePost('/futures/adjust-position-margin', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function adjustPositionLeverage(array $payload): array
    {
        return $this->privatePost('/futures/adjust-position-leverage', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function setPositionStopLoss(array $payload): array
    {
        return $this->privatePost('/futures/set-position-stop-loss', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function setPositionTakeProfit(array $payload): array
    {
        return $this->privatePost('/futures/set-position-take-profit', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function modifyPositionStopLoss(array $payload): array
    {
        return $this->privatePost('/futures/modify-position-stop-loss', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function modifyPositionTakeProfit(array $payload): array
    {
        return $this->privatePost('/futures/modify-position-take-profit', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelPositionStopLoss(array $payload): array
    {
        return $this->privatePost('/futures/cancel-position-stop-loss', $payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function cancelPositionTakeProfit(array $payload): array
    {
        return $this->privatePost('/futures/cancel-position-take-profit', $payload);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPendingPosition(array $query = []): array
    {
        return $this->privateGet('/futures/pending-position', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listFinishedPosition(array $query = []): array
    {
        return $this->privateGet('/futures/finished-position', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPositionMarginHistory(array $query = []): array
    {
        return $this->privateGet('/futures/position-margin-history', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPositionFundingHistory(array $query = []): array
    {
        return $this->privateGet('/futures/position-funding-history', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPositionAdlHistory(array $query = []): array
    {
        return $this->privateGet('/futures/position-adl-history', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listPositionSettleHistory(array $query = []): array
    {
        return $this->privateGet('/futures/position-settle-history', $query);
    }
}
