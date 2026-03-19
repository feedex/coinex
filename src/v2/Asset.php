<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2;

use Feedex\Coinex\v2\Http\CoinexHttpClient;

/**
 * @deprecated Use Feedex\Coinex\v2\Modules\Asset via Coinex::asset()
 */
final class Asset extends Modules\Asset
{
    public function __construct(
        string $accessId,
        string $secretKey,
        string $baseUrl = 'https://api.coinex.com',
        int $timeout = 60
    ) {
        parent::__construct(new CoinexHttpClient($accessId, $secretKey, $baseUrl, $timeout));
    }
}
