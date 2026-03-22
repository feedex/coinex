<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

final class FuturesDeal extends Module
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listUserDeals(array $query = []): array
    {
        return $this->privateGet('/futures/user-deals', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listUserOrderDeals(array $query): array
    {
        return $this->privateGet('/futures/order-deals', $query);
    }
}
