<?php

declare(strict_types=1);

namespace Feedex\Coinex\v2;

use Feedex\Coinex\v2\Http\CoinexHttpClient;
use Feedex\Coinex\v2\Modules\Account;
use Feedex\Coinex\v2\Modules\AccountSub;
use Feedex\Coinex\v2\Modules\Asset;
use Feedex\Coinex\v2\Modules\AssetDepositWithdrawal;
use Feedex\Coinex\v2\Modules\AssetLoan;
use Feedex\Coinex\v2\Modules\AssetTransfer;
use Feedex\Coinex\v2\Modules\Common;
use Feedex\Coinex\v2\Modules\FuturesDeal;
use Feedex\Coinex\v2\Modules\FuturesMarket;
use Feedex\Coinex\v2\Modules\FuturesOrder;
use Feedex\Coinex\v2\Modules\FuturesPosition;
use Feedex\Coinex\v2\Modules\SpotDeal;
use Feedex\Coinex\v2\Modules\SpotMarket;
use Feedex\Coinex\v2\Modules\SpotOrder;
use Feedex\Contracts\Capabilities\HasAccountModuleInterface;
use Feedex\Contracts\Capabilities\HasAccountSubModuleInterface;
use Feedex\Contracts\Capabilities\HasAssetDepositWithdrawalModuleInterface;
use Feedex\Contracts\Capabilities\HasAssetLoanModuleInterface;
use Feedex\Contracts\Capabilities\HasAssetModuleInterface;
use Feedex\Contracts\Capabilities\HasAssetTransferModuleInterface;
use Feedex\Contracts\Capabilities\HasCommonModuleInterface;
use Feedex\Contracts\Capabilities\HasFuturesDealModuleInterface;
use Feedex\Contracts\Capabilities\HasFuturesMarketModuleInterface;
use Feedex\Contracts\Capabilities\HasFuturesOrderModuleInterface;
use Feedex\Contracts\Capabilities\HasFuturesPositionModuleInterface;
use Feedex\Contracts\Capabilities\HasSpotDealModuleInterface;
use Feedex\Contracts\Capabilities\HasSpotMarketModuleInterface;
use Feedex\Contracts\Capabilities\HasSpotOrderModuleInterface;
use Feedex\Contracts\ExchangeInterface;

final class Coinex implements
    ExchangeInterface,
    HasCommonModuleInterface,
    HasAccountModuleInterface,
    HasAccountSubModuleInterface,
    HasAssetModuleInterface,
    HasAssetTransferModuleInterface,
    HasAssetDepositWithdrawalModuleInterface,
    HasAssetLoanModuleInterface,
    HasSpotMarketModuleInterface,
    HasSpotOrderModuleInterface,
    HasSpotDealModuleInterface,
    HasFuturesMarketModuleInterface,
    HasFuturesOrderModuleInterface,
    HasFuturesDealModuleInterface,
    HasFuturesPositionModuleInterface
{
    private CoinexHttpClient $httpClient;

    public function __construct(
        string $accessId,
        string $secretKey,
        string $baseUrl = 'https://api.coinex.com',
        int $timeout = 60,
        int $maxRetries = 0,
        int $retryDelayMs = 100,
        float $retryBackoffMultiplier = 2.0
    ) {
        $this->httpClient = new CoinexHttpClient(
            $accessId,
            $secretKey,
            $baseUrl,
            $timeout,
            $maxRetries,
            $retryDelayMs,
            $retryBackoffMultiplier
        );
    }

    public function id(): string
    {
        return 'coinex';
    }

    public function common(): Common
    {
        return new Common($this->httpClient);
    }

    public function account(): Account
    {
        return new Account($this->httpClient);
    }

    public function asset(): Asset
    {
        return new Asset($this->httpClient);
    }

    public function accountSub(): AccountSub
    {
        return new AccountSub($this->httpClient);
    }

    public function assetTransfer(): AssetTransfer
    {
        return new AssetTransfer($this->httpClient);
    }

    public function assetDepositWithdrawal(): AssetDepositWithdrawal
    {
        return new AssetDepositWithdrawal($this->httpClient);
    }

    public function assetLoan(): AssetLoan
    {
        return new AssetLoan($this->httpClient);
    }

    public function spotMarket(): SpotMarket
    {
        return new SpotMarket($this->httpClient);
    }

    public function spotOrder(): SpotOrder
    {
        return new SpotOrder($this->httpClient);
    }

    public function spotDeal(): SpotDeal
    {
        return new SpotDeal($this->httpClient);
    }

    public function futuresMarket(): FuturesMarket
    {
        return new FuturesMarket($this->httpClient);
    }

    public function futuresOrder(): FuturesOrder
    {
        return new FuturesOrder($this->httpClient);
    }

    public function futuresDeal(): FuturesDeal
    {
        return new FuturesDeal($this->httpClient);
    }

    public function futuresPosition(): FuturesPosition
    {
        return new FuturesPosition($this->httpClient);
    }
}
