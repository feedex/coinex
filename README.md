# feedex/coinex

CoinEx adapter package for [`feedex/feedex`](https://github.com/feedex/feedex).

## Installation

```bash
composer require feedex/feedex feedex/coinex
```

## Usage with Feedex core

```php
use Feedex\Feedex;
use Feedex\Coinex\v2\CoinexFactory;

$feedex = (new Feedex())
    ->register(new CoinexFactory());

$coinex = $feedex->exchange('coinex', [
    'access_id' => getenv('COINEX_ACCESS_ID'),
    'secret_key' => getenv('COINEX_SECRET_KEY'),
]);

$markets = $coinex->spotMarket()->listMarkets();
```

## Notes

- This package targets CoinEx API v2.
- Depends on core contracts from `feedex/feedex`.
