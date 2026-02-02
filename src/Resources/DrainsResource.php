<?php

namespace Aledaas\BridgeRails\Resources;

class DrainsResource extends BaseResource
{
    public function create(array $payload): array
    {
        return $this->client->post('/drains', $payload);
    }

    public function get(string $id): array
    {
        return $this->client->get("/drains/{$id}");
    }

    public function list(array $query = []): array
    {
        return $this->client->get('/drains', $query);
    }
}
