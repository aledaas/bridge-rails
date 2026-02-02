<?php

namespace Aledaas\BridgeRails\Resources;

class CustomersResource extends BaseResource
{
    /**
     * GET /customers
     * (Ojo: en tu pegado no viene "count", solo "data". Igual devolvemos array tal cual.)
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/customers', $query);
    }

    /**
     * POST /customers
     */
    public function create(array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post('/customers', $payload, $idempotencyKey);
    }

    /**
     * GET /customers/{customerID}
     */
    public function get(string $customerId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}", $query);
    }

    /**
     * PUT /customers/{customerID}
     * (En tu cURL no usa Idempotency-Key; lo dejamos opcional por si Bridge lo acepta.)
     */
    public function update(string $id, array $payload): array
    {
        return $this->client->put("/customers/{$id}", $payload);
    }

    /**
     * DELETE /customers/{customerID}
     */
    public function delete(string $customerId, array $query = []): array
    {
        return $this->client->delete("/customers/{$customerId}", $query);
    }

    /**
     * GET /customers/{customerID}/tos_acceptance_link
     */
    public function tosAcceptanceLink(string $customerId): array
    {
        return $this->client->get("/customers/{$customerId}/tos_acceptance_link");
    }

    /**
     * GET /customers/{customerID}/kyc_link
     */
    public function kycLink(string $customerId): array
    {
        return $this->client->get("/customers/{$customerId}/kyc_link");
    }

    /**
     * GET /customers/{customerID}/transfers
     */
    public function transfers(string $customerId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/transfers", $query);
    }

    /**
     * GET /customers/{customerID}/static_templates
     */
    public function staticTemplates(string $customerId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/static_templates", $query);
    }

    /**
     * POST /customers/tos_links
     *
     * En tu ejemplo es POST sin body, pero devuelve un "url" en data.
     * Igual acepto payload opcional por si el endpoint soporta redirect_uri u otros params.
     */
    public function createTosLink(array $payload = [], ?string $idempotencyKey = null): array
    {
        return $this->client->post('/customers/tos_links', $payload, $idempotencyKey);
    }

    /**
     * Helpers para sub-recursos.
     */
    public function associatedPersons(string $customerId): AssociatedPersonsResource
    {
        return new AssociatedPersonsResource($this->client, $customerId);
    }

    public function externalAccounts(string $customerId): CustomerExternalAccountsResource
    {
        return new CustomerExternalAccountsResource($this->client, $customerId);
    }

    public function fiatPayoutConfiguration(string $customerId): FiatPayoutConfigurationResource
    {
        return new FiatPayoutConfigurationResource($this->client, $customerId);
    }
}
