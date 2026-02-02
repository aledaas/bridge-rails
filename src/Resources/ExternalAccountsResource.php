<?php

namespace Aledaas\BridgeRails\Resources;

class ExternalAccountsResource extends BaseResource
{
    /**
     * GET /external_accounts
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/external_accounts', $query);
    }
}
