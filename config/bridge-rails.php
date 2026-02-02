<?php

return [
    'base_url' => env('BRIDGE_BASE_URL', 'https://api.sandbox.bridge.xyz'),
    'api_key' => env('BRIDGE_API_KEY'),
    'api_prefix' => env('BRIDGE_API_PREFIX', '/v0'),

    'timeout_seconds' => (int) env('BRIDGE_TIMEOUT_SECONDS', 30),
    'retries' => (int) env('BRIDGE_RETRIES', 2),
    'retry_sleep_ms' => (int) env('BRIDGE_RETRY_SLEEP_MS', 200),

    'webhook_public_key' => env('BRIDGE_WEBHOOK_PUBLIC_KEY'),
    'webhook_tolerance_seconds' => (int) env('BRIDGE_WEBHOOK_TOLERANCE_SECONDS', 600),
];
