<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$coinex = coinex_client();

$spot = $coinex->asset()->getSpotBalance();
$futures = $coinex->asset()->getFuturesBalance();

echo "Spot balance:\n";
echo json_encode($spot, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n\n";

echo "Futures balance:\n";
echo json_encode($futures, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";
