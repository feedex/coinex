<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\SpotDealModuleInterface;

final class SpotDeal extends Module implements SpotDealModuleInterface
{
    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listUserDeals(array $query = []): array
    {
        return $this->privateGet('/spot/user-deals', $query);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function listUserOrderDeals(array $query): array
    {
        return $this->privateGet('/spot/order-deals', $query);
    }
}
