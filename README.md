# Bridge Rails for Laravel

Laravel package for integrating **Bridge.xyz financial rails** into backend services.

This package provides a clean abstraction over the Bridge API, enabling Laravel applications to interact with Bridge services while handling authentication, configuration, and webhook verification.

It is currently used internally in projects such as **Saki Wallet** and the **Conversion Engine**.

---

# Features

- Bridge API client
- Webhook signature verification
- Laravel-friendly configuration
- Environment-based configuration via `.env`
- Designed for modular backend architectures
- Reusable across multiple Laravel services

---

# Installation

Add the repository to your `composer.json`:

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "../bridge-rails"
    }
  ]
}

composer require aledaas/bridge-rails

BRIDGE_BASE_URL=https://api.sandbox.bridge.xyz
BRIDGE_API_PREFIX=/v0
BRIDGE_API_KEY=your_api_key_here

use Bridge\Client;

$bridge = new Client();

$response = $bridge->payments()->create([
    'amount' => 100,
    'currency' => 'USD',
]);

use Bridge\WebhookVerifier;

$verifier = new WebhookVerifier();

if ($verifier->verify($payload, $signature)) {
    // Process webhook
}
