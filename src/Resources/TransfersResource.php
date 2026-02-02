<?php

namespace Aledaas\BridgeRails\Resources;

class TransfersResource extends BaseResource
{
    /**
     * GET /transfers
     * Soporta query params (limit, starting_after, ending_before, etc.)
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/transfers', $query);
    }

    /**
     * POST /transfers
     * Idempotency-Key recomendado. Payload según docs.
     */
    public function create(array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post('/transfers', $payload, $idempotencyKey);
    }

    /**
     * GET /transfers/{transferID}
     */
    public function get(string $transferId): array
    {
        return $this->client->get("/transfers/{$transferId}");
    }

    /**
     * PUT /transfers/{transferID}
     * Según docs: amount, developer_fee, developer_fee_percent
     */
    public function update(string $transferId, array $payload, ?string $idempotencyKey = null): array
    {
        // docs usa PUT sin Idempotency-Key, pero tu BridgeClient lo soporta: lo dejamos opcional.
        return $this->client->put("/transfers/{$transferId}", $payload, $idempotencyKey);
    }

    /**
     * DELETE /transfers/{transferID}
     */
    public function delete(string $transferId): array
    {
        return $this->client->delete("/transfers/{$transferId}");
    }

    /**
     * GET /transfers/static_templates
     */
    public function staticTemplates(array $query = []): array
    {
        return $this->client->get('/transfers/static_templates', $query);
    }
}
