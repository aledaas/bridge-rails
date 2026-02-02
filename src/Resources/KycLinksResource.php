<?php

namespace Aledaas\BridgeRails\Resources;

class KycLinksResource extends BaseResource
{
    /**
     * Get all KYC links.
     *
     * GET /kyc_links
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/kyc_links', $query);
    }

    /**
     * Generate a KYC link for an individual or business.
     *
     * POST /kyc_links
     *
     * Payload example:
     * [
     *   'email' => 'user@email.com',
     *   'type' => 'individual' | 'business',
     *   'full_name' => 'John Doe',
     *   'endorsements' => ['base'],
     *   'redirect_uri' => 'https://...'
     * ]
     */
    public function create(array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post('/kyc_links', $payload, $idempotencyKey);
    }

    /**
     * Check the status of a specific KYC link.
     *
     * GET /kyc_links/{kycLinkID}
     */
    public function get(string $kycLinkId): array
    {
        return $this->client->get("/kyc_links/{$kycLinkId}");
    }
}
