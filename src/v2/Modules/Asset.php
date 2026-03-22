<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\AssetModuleInterface;

final class Asset extends Module implements AssetModuleInterface
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function getSpotBalance(array $query = []): array
    {
        return $this->privateGet('/assets/spot/balance', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function getFuturesBalance(array $query = []): array
    {
        return $this->privateGet('/assets/futures/balance', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function getMarginBalance(array $query = []): array
    {
        return $this->privateGet('/assets/margin/balance', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function getFinancialBalance(array $query = []): array
    {
        return $this->privateGet('/assets/financial/balance', $query);
    }
}
