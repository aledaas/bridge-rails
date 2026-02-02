<?php

namespace Aledaas\BridgeRails\Resources;

class FeesResource extends BaseResource
{
    public function list(array $query = []): array
    {
        return $this->client->get('/fees', $query);
    }

    public function get(string $feeId): array
    {
        return $this->client->get("/fees/{$feeId}");
    }
}
