<?php

namespace Aledaas\BridgeRails\Resources;

use Aledaas\BridgeRails\BridgeClient;

final class SignedAgreementsResource
{
    public function __construct(private readonly BridgeClient $client) {}

    /**
     * Bridge Dashboard endpoint (sandbox & prod):
     * POST /dashboard/generate_signed_agreement_id
     *
     * Body example:
     * {
     *   "customer_id": "",
     *   "type": "tos",
     *   "version": "v5"
     * }
     */
    public function generate(array $payload = []): array
    {
        $payload = array_merge([
            'customer_id' => '',
            'type' => 'tos',
            'version' => 'v5',
        ], $payload);

        return $this->client->post('/dashboard/generate_signed_agreement_id', $payload);
    }

    /**
     * Creates a customer ensuring signed_agreement_id exists.
     * This removes friction for the user because the backend generates it automatically.
     *
     * - If payload already has signed_agreement_id, it uses it.
     * - Otherwise, it calls /dashboard/generate_signed_agreement_id (type=tos, version=v5)
     *   and injects the id into the payload.
     */
    public function createWithAutoSignedAgreement(array $payload, ?string $idempotencyKey = null): array
    {
        if (empty($payload['signed_agreement_id'])) {
            $signed = $this->client->post('/dashboard/generate_signed_agreement_id', [
                'customer_id' => '',
                'type' => 'tos',
                'version' => 'v5',
            ]);

            $signedAgreementId = $signed['signed_agreement_id'] ?? null;

            if (!is_string($signedAgreementId) || $signedAgreementId === '') {
                throw new \RuntimeException('Bridge did not return signed_agreement_id');
            }

            $payload['signed_agreement_id'] = $signedAgreementId;
        }

        // Reusa tu create() actual (si existe con idempotencyKey)
        // Si tu create() NO recibe idempotencyKey, llamalo sin segundo parámetro.
        return $this->create($payload, $idempotencyKey);
    }
}
