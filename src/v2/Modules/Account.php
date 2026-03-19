<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\AccountModuleInterface;

final class Account extends Module implements AccountModuleInterface
{
    /** @return array<string, mixed> */
    public function getAccountInfo(): array
    {
        return $this->privateGet('/account/info');
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function getTradeFeeRate(array $query = []): array
    {
        return $this->privateGet('/account/trade-fee-rate', $query);
    }
}
