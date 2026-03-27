<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2\Modules;

use Feedex\Contracts\Modules\AssetTransferModuleInterface;

final class AssetTransfer extends Module implements AssetTransferModuleInterface
{
    public function transfer(array $payload): array
    {
        return $this->privatePost('/assets/transfer', $payload);
    }

    public function listTransferHistory(array $query = []): array
    {
        return $this->privateGet('/assets/transfer-history', $query);
    }
}
