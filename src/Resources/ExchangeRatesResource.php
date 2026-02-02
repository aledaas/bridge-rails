<?php

namespace Aledaas\BridgeRails\Resources;

class ExchangeRatesResource extends BaseResource
{
    /**
     * Get current exchange rate from one currency to another.
     *
     * Bridge endpoint: GET /exchange_rates?from=usd&to=eur
     */
    public function rate(string $from, string $to): array
    {
        return $this->client->get('/exchange_rates', [
            'from' => strtolower($from),
            'to'   => strtolower($to),
        ]);
    }

    /**
     * Low-level access if you prefer passing the query directly.
     */
    public function get(array $query = []): array
    {
        return $this->client->get('/exchange_rates', $query);
    }
}
