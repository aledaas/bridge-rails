<?php

namespace Aledaas\BridgeRails\Resources;

use Aledaas\BridgeRails\BridgeClient;

class FiatPayoutConfigurationResource extends BaseResource
{
    public function __construct(
        BridgeClient $client,
        private readonly string $customerId
    ) {
        parent::__construct($client);
    }

    /**
     * GET /customers/{customerID}/fiat_payout_configuration
     */
    public function get(array $query = []): array
    {
        return $this->client->get("/customers/{$this->customerId}/fiat_payout_configuration", $query);
    }

    /**
     * PATCH /customers/{customerID}/fiat_payout_configuration
     */
    public function update(array $payload, ?string $idempotencyKey = null): array
    {
        // Bridge docs muestran PATCH sin idempotency, pero lo soportamos igual por consistencia del client.
        return $this->client->patch(
            "/customers/{$this->customerId}/fiat_payout_configuration",
            $payload,
            $idempotencyKey
        );
    }
}
