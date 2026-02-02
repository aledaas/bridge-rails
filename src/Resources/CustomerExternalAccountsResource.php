<?php

namespace Aledaas\BridgeRails\Resources;

use Aledaas\BridgeRails\BridgeClient;

class CustomerExternalAccountsResource extends BaseResource
{
    public function __construct(
        BridgeClient $client,
        private readonly string $customerId
    ) {
        parent::__construct($client);
    }

    /**
     * GET /customers/{customerID}/external_accounts
     */
    public function list(array $query = []): array
    {
        return $this->client->get("/customers/{$this->customerId}/external_accounts", $query);
    }

    /**
     * POST /customers/{customerID}/external_accounts
     */
    public function create(array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post("/customers/{$this->customerId}/external_accounts", $payload, $idempotencyKey);
    }

    /**
     * GET /customers/{customerID}/external_accounts/{externalAccountID}
     */
    public function get(string $externalAccountId, array $query = []): array
    {
        return $this->client->get("/customers/{$this->customerId}/external_accounts/{$externalAccountId}", $query);
    }

    /**
     * PUT /customers/{customerID}/external_accounts/{externalAccountID}
     */
    public function update(string $externalAccountId, array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->put(
            "/customers/{$this->customerId}/external_accounts/{$externalAccountId}",
            $payload,
            $idempotencyKey
        );
    }

    /**
     * DELETE /customers/{customerID}/external_accounts/{externalAccountID}
     */
    public function delete(string $externalAccountId, array $query = []): array
    {
        return $this->client->delete("/customers/{$this->customerId}/external_accounts/{$externalAccountId}", $query);
    }

    /**
     * POST /customers/{customerID}/external_accounts/{externalAccountID}/reactivate
     */
    public function reactivate(string $externalAccountId, ?string $idempotencyKey = null): array
    {
        return $this->client->post(
            "/customers/{$this->customerId}/external_accounts/{$externalAccountId}/reactivate",
            [],
            $idempotencyKey
        );
    }
}
