<?php

namespace Aledaas\BridgeRails\Resources;

class FundsRequestsResource extends BaseResource
{
    /**
     * Get all funds requests
     *
     * GET /funds_requests
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/funds_requests', $query);
    }
}
