<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\AccountSubModuleInterface;

final class AccountSub extends Module implements AccountSubModuleInterface
{
    public function createSub(array $payload): array
    {
        return $this->privatePost('/account/subs', $payload);
    }

    public function listSub(array $query = []): array
    {
        return $this->privateGet('/account/subs', $query);
    }

    public function getSubInfo(array $query): array
    {
        return $this->privateGet('/account/subs/info', $query);
    }

    public function frozenSub(array $payload): array
    {
        return $this->privatePost('/account/subs/frozen', $payload);
    }

    public function cancelFrozenSub(array $payload): array
    {
        return $this->privatePost('/account/subs/unfrozen', $payload);
    }

    public function createSubApi(array $payload): array
    {
        return $this->privatePost('/account/subs/api', $payload);
    }

    public function listSubApi(array $query): array
    {
        return $this->privateGet('/account/subs/api', $query);
    }

    public function getSubApi(array $query): array
    {
        return $this->privateGet('/account/subs/api-detail', $query);
    }

    public function editSubApi(array $payload): array
    {
        return $this->privatePost('/account/subs/edit-api', $payload);
    }

    public function deleteSubApi(array $payload): array
    {
        return $this->privatePost('/account/subs/delete-api', $payload);
    }

    public function getSubBalance(array $query): array
    {
        return $this->privateGet('/account/subs/balance', $query);
    }

    public function getSubSpotBalance(array $query): array
    {
        return $this->privateGet('/account/subs/spot-balance', $query);
    }

    public function subTransfer(array $payload): array
    {
        return $this->privatePost('/account/subs/transfer', $payload);
    }

    public function listSubTransferHistory(array $query = []): array
    {
        return $this->privateGet('/account/subs/transfer-history', $query);
    }
}
