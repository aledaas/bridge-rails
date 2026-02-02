<?php

namespace Aledaas\BridgeRails\Resources;

class WebhooksResource extends BaseResource
{
    /**
     * Get all webhook endpoints.
     *
     * GET /webhooks
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/webhooks', $query);
    }

    /**
     * Create a webhook endpoint.
     *
     * POST /webhooks
     *
     * Payload example:
     * [
     *   'url' => 'https://my_endpoint.xyz/hooks',
     *   'event_epoch' => 'webhook_creation',
     *   'event_categories' => ['customer']
     * ]
     */
    public function create(array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post('/webhooks', $payload, $idempotencyKey);
    }

    /**
     * Update a webhook endpoint.
     *
     * PUT /webhooks/{webhookID}
     *
     * Payload example:
     * [
     *   'url' => 'https://my_updated_endpoint.xyz/hooks',
     *   'status' => 'active',
     *   'event_categories' => ['customer']
     * ]
     */
    public function update(string $webhookId, array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->put("/webhooks/{$webhookId}", $payload, $idempotencyKey);
    }

    /**
     * Delete a webhook endpoint.
     *
     * DELETE /webhooks/{webhookID}
     */
    public function delete(string $webhookId): array
    {
        return $this->client->delete("/webhooks/{$webhookId}");
    }

    /**
     * List upcoming events for a webhook.
     *
     * GET /webhooks/{webhookID}/events
     */
    public function events(string $webhookId, array $query = []): array
    {
        return $this->client->get("/webhooks/{$webhookId}/events", $query);
    }

    /**
     * View logs for a webhook.
     *
     * GET /webhooks/{webhookID}/logs
     */
    public function logs(string $webhookId, array $query = []): array
    {
        return $this->client->get("/webhooks/{$webhookId}/logs", $query);
    }

    /**
     * Send an event for a webhook (replay).
     *
     * POST /webhooks/{webhookID}/send
     *
     * Payload example:
     * [
     *   'event_id' => '...'
     * ]
     */
    public function send(string $webhookId, string $eventId, ?string $idempotencyKey = null): array
    {
        return $this->client->post(
            "/webhooks/{$webhookId}/send",
            ['event_id' => $eventId],
            $idempotencyKey
        );
    }
}
