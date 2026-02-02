<?php

namespace Aledaas\BridgeRails\Resources;

class AssociatedPersonsResource extends BaseResource
{
    public function __construct(
        \Aledaas\BridgeRails\BridgeClient $client,
        private readonly string $customerId
    ) {
        parent::__construct($client);
    }

    /**
     * GET /customers/{customerID}/associated_persons
     */
    public function list(array $query = []): array
    {
        return $this->client->get("/customers/{$this->customerId}/associated_persons", $query);
    }

    /**
     * POST /customers/{customerID}/associated_persons
     */
    public function create(array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post("/customers/{$this->customerId}/associated_persons", $payload, $idempotencyKey);
    }

    /**
     * GET /customers/{customerID}/associated_persons/{associatedPersonID}
     */
    public function get(string $associatedPersonId, array $query = []): array
    {
        return $this->client->get("/customers/{$this->customerId}/associated_persons/{$associatedPersonId}", $query);
    }

    /**
     * PUT /customers/{customerID}/associated_persons/{associatedPersonID}
     */
    public function update(string $associatedPersonId, array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->put(
            "/customers/{$this->customerId}/associated_persons/{$associatedPersonId}",
            $payload,
            $idempotencyKey
        );
    }

    /**
     * DELETE /customers/{customerID}/associated_persons/{associatedPersonID}
     */
    public function delete(string $associatedPersonId, array $query = []): array
    {
        return $this->client->delete("/customers/{$this->customerId}/associated_persons/{$associatedPersonId}", $query);
    }
}
