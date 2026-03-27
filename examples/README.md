# Examples

These scripts are intentionally simple and are designed to show SDK usability for common tasks.

## Setup

```bash
composer install
export COINEX_ACCESS_ID="your-access-id"
export COINEX_SECRET_KEY="your-secret-key"
```

Optional:

```bash
export COINEX_BASE_URL="https://api.coinex.com"
export COINEX_TIMEOUT=60
```

## Safety switch

Order examples are **dry-run by default** and do not send order requests unless you explicitly enable execution.

```bash
export COINEX_EXECUTE=1
```

## Run

```bash
php examples/balances.php
php examples/spot_order.php
php examples/futures_order.php
```
