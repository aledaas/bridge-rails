<?php

namespace Aledaas\BridgeRails\Resources;

class IssuanceResource extends BaseResource
{
    // Lo dejamos “mínimo viable” porque issuance suele tener sub-rutas específicas.
    // La idea es que acá agreguemos métodos concretos apenas mires el detalle de issuance en la docs.

    public function list(array $query = []): array
    {
        return $this->client->get('/issuance', $query);
    }

    public function get(string $id): array
    {
        return $this->client->get("/issuance/{$id}");
    }
}
