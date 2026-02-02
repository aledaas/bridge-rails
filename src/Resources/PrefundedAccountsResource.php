<?php

namespace Aledaas\BridgeRails\Resources;

class PrefundedAccountsResource extends BaseResource
{
    /**
     * GET /prefunded_accounts
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/prefunded_accounts', $query);
    }

    /**
     * GET /prefunded_accounts/{prefundedAccountID}
     */
    public function get(string $prefundedAccountId): array
    {
        return $this->client->get("/prefunded_accounts/{$prefundedAccountId}");
    }

    /**
     * GET /prefunded_accounts/{prefundedAccountID}/history
     */
    public function history(string $prefundedAccountId, array $query = []): array
    {
        return $this->client->get("/prefunded_accounts/{$prefundedAccountId}/history", $query);
    }
}
