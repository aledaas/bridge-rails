<?php

namespace Aledaas\BridgeRails\Resources;

class CryptoReturnPoliciesResource extends BaseResource
{
    /**
     * Get all crypto return policies
     * GET /crypto_return_policies
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/crypto_return_policies', $query);
    }

    /**
     * Create a new crypto return policy
     * POST /crypto_return_policies
     */
    public function create(array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post('/crypto_return_policies', $payload, $idempotencyKey);
    }

    /**
     * Update an existing crypto return policy
     * PUT /crypto_return_policies/{policyID}
     */
    public function update(string $policyId, array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->put("/crypto_return_policies/{$policyId}", $payload, $idempotencyKey);
    }

    /**
     * Delete a single crypto return policy object
     * DELETE /crypto_return_policies/{policyID}
     */
    public function delete(string $policyId): array
    {
        return $this->client->delete("/crypto_return_policies/{$policyId}");
    }
}
