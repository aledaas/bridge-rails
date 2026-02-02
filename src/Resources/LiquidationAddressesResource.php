<?php

namespace Aledaas\BridgeRails\Resources;

class LiquidationAddressesResource extends BaseResource
{
    /**
     * GET /customers/{customerID}/liquidation_addresses
     */
    public function listForCustomer(string $customerId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/liquidation_addresses", $query);
    }

    /**
     * POST /customers/{customerID}/liquidation_addresses
     * Idempotency-Key: yes (BridgeClient ya la genera si no se la pasas)
     */
    public function createForCustomer(string $customerId, array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post("/customers/{$customerId}/liquidation_addresses", $payload, $idempotencyKey);
    }

    /**
     * GET /liquidation_addresses
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/liquidation_addresses', $query);
    }

    /**
     * GET /customers/{customerID}/liquidation_addresses/{liquidationAddressID}
     */
    public function get(string $customerId, string $liquidationAddressId): array
    {
        return $this->client->get("/customers/{$customerId}/liquidation_addresses/{$liquidationAddressId}");
    }

    /**
     * PUT /customers/{customerID}/liquidation_addresses/{liquidationAddressID}
     * (en tu doc no pide Idempotency-Key; igual lo podríamos soportar si querés)
     */
    public function update(string $customerId, string $liquidationAddressId, array $payload): array
    {
        return $this->client->put("/customers/{$customerId}/liquidation_addresses/{$liquidationAddressId}", $payload);
    }

    /**
     * GET /customers/{customerID}/liquidation_addresses/{liquidationAddressID}/drains
     */
    public function drains(string $customerId, string $liquidationAddressId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/liquidation_addresses/{$liquidationAddressId}/drains", $query);
    }

    /**
     * POST /customers/{customerID}/liquidation_addresses/{liquidationAddressID}/simulate_deposit
     * Sandbox only. Idempotency-Key: yes
     */
    public function simulateDeposit(
        string $customerId,
        string $liquidationAddressId,
        array $payload,
        ?string $idempotencyKey = null
    ): array {
        return $this->client->post(
            "/customers/{$customerId}/liquidation_addresses/{$liquidationAddressId}/simulate_deposit",
            $payload,
            $idempotencyKey
        );
    }

    /**
     * GET /liquidation_addresses/drains
     * (Activity Across All Customers)
     */
    public function drainsAcrossAllCustomers(array $query = []): array
    {
        return $this->client->get('/liquidation_addresses/drains', $query);
    }

    /**
     * Get the balance of a Liquidation Address (deprecated)
     *
     * @deprecated Bridge indica que la mayoría de las Liquidation Addresses ya no mantienen balance real.
     *             Para actividad/estado, usar:
     *             GET /customers/{customerID}/liquidation_addresses/{liquidationAddressID}/drains
     *
     * GET /customers/{customerID}/liquidation_addresses/{liquidationAddressID}/balances
     *
     * Response:
     * - active_balance: string
     * - pending_balance: string
     */
    public function balances(string $customerId, string $liquidationAddressId): array
    {
        return $this->client->get(
            "/customers/{$customerId}/liquidation_addresses/{$liquidationAddressId}/balances"
        );
    }
}
