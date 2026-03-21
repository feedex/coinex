<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

final class FuturesMarket extends Module
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarkets(array $query = []): array
    {
        return $this->publicGet('/futures/market', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketTicker(array $query = []): array
    {
        return $this->publicGet('/futures/ticker', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketDepth(array $query): array
    {
        return $this->publicGet('/futures/depth', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketDeals(array $query): array
    {
        return $this->publicGet('/futures/deals', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketKline(array $query): array
    {
        return $this->publicGet('/futures/kline', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketIndex(array $query = []): array
    {
        return $this->publicGet('/futures/index', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketFundingRate(array $query = []): array
    {
        return $this->publicGet('/futures/funding-rate', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketFundingRateHistory(array $query): array
    {
        return $this->publicGet('/futures/funding-rate-history', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketBasisHistory(array $query): array
    {
        return $this->publicGet('/futures/basis-history', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketLiquidationHistory(array $query): array
    {
        return $this->publicGet('/futures/liquidation-history', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketPositionLevel(array $query): array
    {
        return $this->publicGet('/futures/position-level', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listMarketPremiumHistory(array $query): array
    {
        return $this->publicGet('/futures/premium-index-history', $query);
    }
}
