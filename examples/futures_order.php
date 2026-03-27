<?php

declare(strict_types=1);

use Feedex\Coinex\v2\Payload\FuturesOrderPayload;

require __DIR__ . '/bootstrap.php';

$payload = FuturesOrderPayload::limit(
    market: 'BTCUSDT',
    side: 'buy',
    amount: '1',
    price: '10000',
    extra: [
        'client_id' => 'example-futures-order-001',
    ]
);

if (!coinex_execute_enabled()) {
    echo "DRY RUN: set COINEX_EXECUTE=1 to send the order.\n";
    echo json_encode($payload->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";
    exit(0);
}

$coinex = coinex_client();
$result = $coinex->futuresOrder()->putOrderPayload($payload);

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";
