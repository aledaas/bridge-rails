<?php

namespace Aledaas\BridgeRails\Resources;

class BatchSettlementSchedulesResource extends BaseResource
{
    /**
     * Create a Batch Settlement Schedule for a customer
     *
     * POST /customers/{customerID}/batch_settlement_schedules
     *
     * @param  string       $customerId
     * @param  array        $destination  Destination payload (as Bridge expects)
     * @param  string|null  $idempotencyKey
     */
    public function createForCustomer(string $customerId, array $destination, ?string $idempotencyKey = null): array
    {
        $payload = [
            'destination' => $destination,
        ];

        return $this->client->post("/customers/{$customerId}/batch_settlement_schedules", $payload, $idempotencyKey);
    }
}
