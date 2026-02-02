<?php

namespace Aledaas\BridgeRails\Resources;

class RewardsResource extends BaseResource
{
    /**
     * Get the current reward rates
     * GET /rewards/rates
     */
    public function getCurrentRates(): array
    {
        return $this->client->get('/rewards/rates');
    }

    /**
     * Get a summary of all rewards for a given stablecoin
     * GET /rewards/{currency}
     */
    public function getSummaryByCurrency(string $currency): array
    {
        return $this->client->get('/rewards/' . strtolower($currency));
    }

    /**
     * Get the currency reward rates for a given stablecoin
     * GET /rewards/{currency}/rates
     */
    public function getRatesByCurrency(string $currency): array
    {
        return $this->client->get('/rewards/' . strtolower($currency) . '/rates');
    }

    /**
     * Get a summary of a customer's rewards
     * GET /rewards/{currency}/customer/{customerID}
     */
    public function getCustomerSummary(string $currency, string $customerId): array
    {
        return $this->client->get('/rewards/' . strtolower($currency) . "/customer/{$customerId}");
    }

    /**
     * Get a history of a customer's rewards
     * GET /rewards/{currency}/customer/{customerID}/history
     */
    public function getCustomerHistory(string $currency, string $customerId): array
    {
        return $this->client->get('/rewards/' . strtolower($currency) . "/customer/{$customerId}/history");
    }
}
