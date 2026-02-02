<?php

namespace Aledaas\BridgeRails\Resources;

class DevelopersResource extends BaseResource
{
    /**
     * Get the configured fees.
     *
     * GET /developer/fees
     */
    public function getFees(): array
    {
        return $this->client->get('/developer/fees');
    }

    /**
     * Update the configured fees.
     *
     * POST /developer/fees
     *
     * Payload example:
     * [
     *   'default_liquidation_address_fee_percent' => '0.5'
     * ]
     */
    public function updateFees(array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post('/developer/fees', $payload, $idempotencyKey);
    }

    /**
     * Get the configured fee External Account.
     *
     * GET /developer/fee_external_account
     */
    public function getFeeExternalAccount(): array
    {
        return $this->client->get('/developer/fee_external_account');
    }

    /**
     * Configure a fee External Account.
     *
     * POST /developer/fee_external_account
     *
     * Payload example:
     * [
     *   'currency' => 'usd',
     *   'bank_name' => 'Wells Fargo',
     *   'account_owner_name' => 'John Doe',
     *   'account_type' => 'us',
     *   'account' => [
     *     'account_number' => '1210002481111',
     *     'routing_number' => '121000248',
     *     'checking_or_savings' => 'checking',
     *   ],
     *   'address' => [
     *     'street_line_1' => '123 Main St',
     *     'city' => 'San Francisco',
     *     'state' => 'CA',
     *     'postal_code' => '94102',
     *     'country' => 'USA',
     *   ]
     * ]
     */
    public function configureFeeExternalAccount(array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post('/developer/fee_external_account', $payload, $idempotencyKey);
    }
}
