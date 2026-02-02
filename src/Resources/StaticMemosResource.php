<?php

namespace Aledaas\BridgeRails\Resources;

class StaticMemosResource extends BaseResource
{
    /**
     * List Static Memos (across all customers)
     * GET /static_memos
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/static_memos', $query);
    }

    /**
     * List Static Memos for a Customer
     * GET /customers/{customerID}/static_memos
     */
    public function listByCustomer(string $customerId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/static_memos", $query);
    }

    /**
     * Create a Static Memo
     * POST /customers/{customerID}/static_memos
     */
    public function create(string $customerId, array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post("/customers/{$customerId}/static_memos", $payload, $idempotencyKey);
    }

    /**
     * Get a Static Memo
     * GET /customers/{customerID}/static_memos/{staticMemoID}
     */
    public function get(string $customerId, string $staticMemoId): array
    {
        return $this->client->get("/customers/{$customerId}/static_memos/{$staticMemoId}");
    }

    /**
     * Update a Static Memo
     * PUT /customers/{customerID}/static_memos/{staticMemoID}
     */
    public function update(string $customerId, string $staticMemoId, array $payload, ?string $idempotencyKey = null): array
    {
        // En tu spec no aparece Idempotency-Key para PUT, pero lo dejamos opcional por consistencia.
        return $this->client->put("/customers/{$customerId}/static_memos/{$staticMemoId}", $payload, $idempotencyKey);
    }

    /**
     * Static Memo Activity (history) for a specific Static Memo
     * GET /customers/{customerID}/static_memos/{staticMemoID}/history
     */
    public function history(string $customerId, string $staticMemoId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/static_memos/{$staticMemoId}/history", $query);
    }

    /**
     * Static Memo Activity Across All Customers
     * GET /static_memos/history
     */
    public function historyAll(array $query = []): array
    {
        return $this->client->get('/static_memos/history', $query);
    }
}
