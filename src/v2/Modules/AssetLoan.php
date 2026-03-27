<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\AssetLoanModuleInterface;

final class AssetLoan extends Module implements AssetLoanModuleInterface
{
    public function marginBorrow(array $payload): array
    {
        return $this->privatePost('/assets/margin/borrow', $payload);
    }

    public function marginRepay(array $payload): array
    {
        return $this->privatePost('/assets/margin/repay', $payload);
    }

    public function listMarginBorrowHistory(array $query = []): array
    {
        return $this->privateGet('/assets/margin/borrow-history', $query);
    }

    public function listMarginInterestLimit(array $query = []): array
    {
        return $this->privateGet('/assets/margin/interest-limit', $query);
    }
}
