<?php

namespace Aledaas\BridgeRails\Resources;

class BalancesResource extends BaseResource
{
    public function forCustomer(string $customerId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/balances", $query);
    }

    public function forWallet(string $walletId, array $query = []): array
    {
        return $this->client->get("/wallets/{$walletId}/balances", $query);
    }
}
