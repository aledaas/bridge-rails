<?php

namespace Aledaas\BridgeRails\Resources;

use Aledaas\BridgeRails\BridgeClient;

class PlaidResource extends BaseResource
{
    /**
     * POST /customers/{customerID}/plaid_link_requests
     */
    public function createLinkTokenForCustomer(string $customerId, ?string $idempotencyKey = null): array
    {
        // En docs no hay body. Mandamos [].
        return $this->client->post(
            "/customers/{$customerId}/plaid_link_requests",
            [],
            $idempotencyKey
        );
    }

    /**
     * POST /plaid_exchange_public_token/{link_token}
     */
    public function exchangePublicToken(string $linkToken, string $publicToken, ?string $idempotencyKey = null): array
    {
        return $this->client->post(
            "/plaid_exchange_public_token/{$linkToken}",
            ['public_token' => $publicToken],
            $idempotencyKey
        );
    }
}
