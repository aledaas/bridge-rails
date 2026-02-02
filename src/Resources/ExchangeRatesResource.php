<?php

namespace Aledaas\BridgeRails\Resources;

class ExchangeRatesResource extends BaseResource
{
    /**
     * Get current exchange rate between two currencies.
     *
     * GET /exchange_rates
     *
     * Typical query example (depends on Bridge docs):
     * [
     *   'from' => 'USD',
     *   'to'   => 'EUR',
     * ]
     */
    public function get(array $query = []): array
    {
        return $this->client->get('/exchange_rates', $query);
    }
}
