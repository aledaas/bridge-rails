<?php

namespace Aledaas\BridgeRails\Resources;

class VirtualAccountsResource extends BaseResource
{
    /**
     * List Virtual Accounts by Customer
     * GET /customers/{customerID}/virtual_accounts
     */
    public function listByCustomer(string $customerId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/virtual_accounts", $query);
    }

    /**
     * Create a Virtual Account
     * POST /customers/{customerID}/virtual_accounts
     */
    public function create(string $customerId, array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post("/customers/{$customerId}/virtual_accounts", $payload, $idempotencyKey);
    }

    /**
     * Get a Virtual Account
     * GET /customers/{customerID}/virtual_accounts/{virtualAccountID}
     */
    public function get(string $customerId, string $virtualAccountId): array
    {
        return $this->client->get("/customers/{$customerId}/virtual_accounts/{$virtualAccountId}");
    }

    /**
     * Update a Virtual Account
     * PUT /customers/{customerID}/virtual_accounts/{virtualAccountID}
     */
    public function update(string $customerId, string $virtualAccountId, array $payload, ?string $idempotencyKey = null): array
    {
        // en la doc es PUT; tu BridgeClient soporta put con Idempotency-Key opcional
        return $this->client->put("/customers/{$customerId}/virtual_accounts/{$virtualAccountId}", $payload, $idempotencyKey);
    }

    /**
     * Deactivate a Virtual Account
     * POST /customers/{customerID}/virtual_accounts/{virtualAccountID}/deactivate
     */
    public function deactivate(string $customerId, string $virtualAccountId, ?string $idempotencyKey = null): array
    {
        // POST sin body (igual BridgeClient requiere payload en post; usamos [])
        return $this->client->post(
            "/customers/{$customerId}/virtual_accounts/{$virtualAccountId}/deactivate",
            [],
            $idempotencyKey
        );
    }

    /**
     * Reactivate a Virtual Account
     * POST /customers/{customerID}/virtual_accounts/{virtualAccountID}/reactivate
     */
    public function reactivate(string $customerId, string $virtualAccountId, ?string $idempotencyKey = null): array
    {
        return $this->client->post(
            "/customers/{$customerId}/virtual_accounts/{$virtualAccountId}/reactivate",
            [],
            $idempotencyKey
        );
    }

    /**
     * Simulate a fiat deposit (Sandbox only)
     * POST /customers/{customerID}/virtual_accounts/{virtualAccountID}/simulate_deposit
     */
    public function simulateDeposit(string $customerId, string $virtualAccountId, array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post(
            "/customers/{$customerId}/virtual_accounts/{$virtualAccountId}/simulate_deposit",
            $payload,
            $idempotencyKey
        );
    }

    /**
     * Virtual Account Activity (history) for a specific virtual account
     * GET /customers/{customerID}/virtual_accounts/{virtualAccountID}/history
     */
    public function history(string $customerId, string $virtualAccountId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/virtual_accounts/{$virtualAccountId}/history", $query);
    }

    /**
     * List Virtual Accounts (across all customers)
     * GET /virtual_accounts
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/virtual_accounts', $query);
    }

    /**
     * Virtual Account Activity Across All Customers
     * GET /virtual_accounts/history
     */
    public function historyAll(array $query = []): array
    {
        return $this->client->get('/virtual_accounts/history', $query);
    }
}
