# feedex/coinex

CoinEx adapter package for the Feedex ecosystem.

This package implements CoinEx API v2 modules and plugs into `feedex/feedex` via factory registration.

## Installation

```bash
composer require feedex/feedex feedex/coinex
```

## Compatibility

- `feedex/coinex ^0.2` requires `feedex/feedex ^0.1.5`

## Usage (recommended via Feedex core)

```php
use Feedex\Feedex;
use Feedex\Coinex\v2\CoinexFactory;

$feedex = (new Feedex())
    ->register(new CoinexFactory());

$coinex = $feedex->exchange('coinex', [
    'access_id' => getenv('COINEX_ACCESS_ID'),
    'secret_key' => getenv('COINEX_SECRET_KEY'),
    // optional:
    // 'base_url' => 'https://api.coinex.com',
    // 'timeout' => 60,
]);

$markets = $coinex->spotMarket()->listMarkets();
$balance = $coinex->asset()->getSpotBalance();
```

## Direct usage (without registry)

```php
use Feedex\Coinex\v2\Coinex;

$coinex = new Coinex(
    accessId: getenv('COINEX_ACCESS_ID'),
    secretKey: getenv('COINEX_SECRET_KEY')
);

$tickers = $coinex->spotMarket()->listMarketTicker();
```

## Implemented modules

### Common (public)
- `ping()`
- `time()`
- `maintainInfo()`

### Account (private)
- `getAccountInfo()`
- `getTradeFeeRate()`

### Asset (private)
- `getSpotBalance()`
- `getFuturesBalance()`
- `getMarginBalance()`
- `getFinancialBalance()`

### Account Sub (private)
- `createSub()`
- `listSub()`
- `getSubInfo()`
- `frozenSub()`
- `cancelFrozenSub()`
- `createSubApi()`
- `listSubApi()`
- `getSubApi()`
- `editSubApi()`
- `deleteSubApi()`
- `getSubBalance()`
- `getSubSpotBalance()`
- `subTransfer()`
- `listSubTransferHistory()`

### Asset Transfer (private)
- `transfer()`
- `listTransferHistory()`

### Asset Deposit/Withdrawal (private)
- `listAssetsInfo()`
- `getDepositAddress()`
- `updateDepositAddress()`
- `getDepositWithdrawalConfig()`
- `listAllDepositWithdrawalConfig()`
- `listDepositHistory()`
- `listWithdrawalHistory()`
- `withdrawal()`
- `cancelWithdrawal()`

### Asset Loan (private)
- `marginBorrow()`
- `marginRepay()`
- `listMarginBorrowHistory()`
- `listMarginInterestLimit()`

### Spot Market (public)
- `listMarkets()`
- `listMarketTicker()`
- `listMarketDepth()`
- `listMarketDeals()`
- `listMarketKline()`
- `listMarketIndex()`

### Spot Order (private)
- `putOrder()`
- `putBatchOrder()`
- `putStopOrder()`
- `putBatchStopOrder()`
- `editOrder()`
- `editBatchOrder()`
- `editStopOrder()`
- `cancelOrder()`
- `cancelOrderByClientId()`
- `cancelBatchOrder()`
- `cancelAllOrder()`
- `cancelStopOrder()`
- `cancelStopOrderByClientId()`
- `cancelBatchStopOrder()`
- `getOrderStatus()`
- `getBatchOrderStatus()`
- `listPendingOrder()`
- `listFinishedOrder()`
- `listPendingStopOrder()`
- `listFinishedStopOrder()`

### Spot Deal (private)
- `listUserDeals()`
- `listUserOrderDeals()`

### Futures Market (public)
- `listMarkets()`
- `listMarketTicker()`
- `listMarketDepth()`
- `listMarketDeals()`
- `listMarketKline()`
- `listMarketIndex()`
- `listMarketFundingRate()`
- `listMarketFundingRateHistory()`
- `listMarketBasisHistory()`
- `listMarketLiquidationHistory()`
- `listMarketPositionLevel()`
- `listMarketPremiumHistory()`

### Futures Order (private)
- `putOrder()`
- `putBatchOrder()`
- `putStopOrder()`
- `putBatchStopOrder()`
- `editOrder()`
- `editBatchOrder()`
- `editStopOrder()`
- `cancelOrder()`
- `cancelOrderByClientId()`
- `cancelBatchOrder()`
- `cancelAllOrder()`
- `cancelStopOrder()`
- `cancelStopOrderByClientId()`
- `cancelBatchStopOrder()`
- `getOrderStatus()`
- `getBatchOrderStatus()`
- `listPendingOrder()`
- `listFinishedOrder()`
- `listPendingStopOrder()`
- `listFinishedStopOrder()`

### Futures Deal (private)
- `listUserDeals()`
- `listUserOrderDeals()`

### Futures Position (private)
- `closePosition()`
- `adjustPositionMargin()`
- `adjustPositionLeverage()`
- `setPositionStopLoss()`
- `setPositionTakeProfit()`
- `modifyPositionStopLoss()`
- `modifyPositionTakeProfit()`
- `cancelPositionStopLoss()`
- `cancelPositionTakeProfit()`
- `listPendingPosition()`
- `listFinishedPosition()`
- `listPositionMarginHistory()`
- `listPositionFundingHistory()`
- `listPositionAdlHistory()`
- `listPositionSettleHistory()`

## Authentication notes

CoinEx v2 signature format used by this adapter:

`METHOD + request_path(+query_string) + body + timestamp`

Request headers:
- `X-COINEX-KEY`
- `X-COINEX-SIGN`
- `X-COINEX-TIMESTAMP`

## Quality architecture additions

### Lightweight payload builders/validators

Available for complex order calls:
- `Feedex\Coinex\v2\Payload\SpotOrderPayload`
- `Feedex\Coinex\v2\Payload\FuturesOrderPayload`

These provide reusable payload construction and basic required-key validation without heavy abstraction.

### Typed error model

The HTTP layer maps failures into typed exceptions:
- `CoinexAuthenticationException`
- `CoinexRateLimitException`
- `CoinexValidationException`
- `CoinexTransientException`
- fallback: `CoinexRequestException`

### Optional retry/backoff (disabled by default)

You can configure retries through factory config:
- `max_retries` (default `0`)
- `retry_delay_ms` (default `100`)
- `retry_backoff_multiplier` (default `2.0`)

Example:

```php
$coinex = $feedex->exchange('coinex', [
    'access_id' => 'xxx',
    'secret_key' => 'yyy',
    'max_retries' => 2,
    'retry_delay_ms' => 150,
    'retry_backoff_multiplier' => 2.0,
]);
```

## Core architecture integration

This adapter provides:

- `Feedex\Coinex\v2\Coinex` implementing Feedex exchange/capability contracts
- `Feedex\Coinex\v2\CoinexFactory` implementing `ExchangeFactoryInterface`

## License

MIT
