<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\AssetDepositWithdrawalModuleInterface;

final class AssetDepositWithdrawal extends Module implements AssetDepositWithdrawalModuleInterface
{
    public function listAssetsInfo(array $query = []): array
    {
        return $this->privateGet('/assets/info', $query);
    }

    public function getDepositAddress(array $query): array
    {
        return $this->privateGet('/assets/deposit-address', $query);
    }

    public function updateDepositAddress(array $payload): array
    {
        return $this->privatePost('/assets/renewal-deposit-address', $payload);
    }

    public function getDepositWithdrawalConfig(array $query): array
    {
        return $this->privateGet('/assets/deposit-withdraw-config', $query);
    }

    public function listAllDepositWithdrawalConfig(array $query = []): array
    {
        return $this->privateGet('/assets/all-deposit-withdraw-config', $query);
    }

    public function listDepositHistory(array $query = []): array
    {
        return $this->privateGet('/assets/deposit-history', $query);
    }

    public function listWithdrawalHistory(array $query = []): array
    {
        return $this->privateGet('/assets/withdraw', $query);
    }

    public function withdrawal(array $payload): array
    {
        return $this->privatePost('/assets/withdraw', $payload);
    }

    public function cancelWithdrawal(array $payload): array
    {
        return $this->privatePost('/assets/cancel-withdraw', $payload);
    }
}
