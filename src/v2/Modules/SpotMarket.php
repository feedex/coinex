<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\SpotMarketModuleInterface;

final class SpotMarket extends Module implements SpotMarketModuleInterface
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarkets(array $query = []): array
    {
        return $this->publicGet('/spot/market', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketTicker(array $query = []): array
    {
        return $this->publicGet('/spot/ticker', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketDepth(array $query): array
    {
        return $this->publicGet('/spot/depth', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketDeals(array $query): array
    {
        return $this->publicGet('/spot/deals', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketKline(array $query): array
    {
        return $this->publicGet('/spot/kline', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketIndex(array $query = []): array
    {
        return $this->publicGet('/spot/index', $query);
    }
}
