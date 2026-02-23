<?php

namespace Aledaas\BridgeRails\Resources;

use RuntimeException;

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
     * Helper: Genera signed_agreement_id automáticamente (si falta) y crea el customer.
     *
     * Esto reduce fricción: el usuario no tiene que hacer un paso previo para obtener el signed_agreement_id.
     *
     * Endpoint usado:
     * POST /dashboard/generate_signed_agreement_id
     * Body: {"customer_id":"","type":"tos","version":"v5"}
     */
    public function createWithAutoSignedAgreement(array $payload, ?string $idempotencyKey = null): array
    {
        if (empty($payload['signed_agreement_id'])) {
            $signed = $this->client->postNoPrefix(
                '/dashboard/generate_signed_agreement_id',
                [
                    'customer_id' => '',
                    'type' => 'tos',
                    'version' => 'v5',
                ],
                // importante: idempotency key distinta a la de /customers si querés evitar colisiones
                // si no te importa, podés pasar null acá
                $idempotencyKey ? ($idempotencyKey . ':signed') : null
            );

            $signedAgreementId = $signed['signed_agreement_id'] ?? null;

            if (!is_string($signedAgreementId) || $signedAgreementId === '') {
                throw new RuntimeException('Bridge did not return signed_agreement_id from /dashboard/generate_signed_agreement_id');
            }

            $payload['signed_agreement_id'] = $signedAgreementId;
        }

        return $this->create($payload, $idempotencyKey);
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
