<?php

declare(strict_types=1);

use Feedex\Coinex\v2\Payload\SpotOrderPayload;

require __DIR__ . '/bootstrap.php';

$payload = SpotOrderPayload::limit(
    market: 'BTCUSDT',
    side: 'buy',
    amount: '0.0001',
    price: '10000',
    extra: [
        'client_id' => 'example-spot-order-001',
    ]
);

if (!coinex_execute_enabled()) {
    echo "DRY RUN: set COINEX_EXECUTE=1 to send the order.\n";
    echo json_encode($payload->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";
    exit(0);
}

$coinex = coinex_client();
$result = $coinex->spotOrder()->putOrderPayload($payload);

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";
