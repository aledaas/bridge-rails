<?php

namespace Aledaas\BridgeRails\Resources;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

final class SignedAgreementsResource
{
    public function __construct() {}

    /**
     * Genera un signed_agreement_id (TOS v5) usando el endpoint dashboard.
     *
     * POST https://api.sandbox.bridge.xyz/dashboard/generate_signed_agreement_id
     * body: {"customer_id":"","type":"tos","version":"v5"}
     *
     * Devuelve: ["signedAgreementId" => "..."] (según lo que viste en Network)
     */
    public function generateTosSignedAgreementId(
        string $version = 'v5',
        ?string $customerId = null,
        ?string $idempotencyKey = null
    ): array {
        $base = (string) config('bridge-rails.base_url'); // ej: https://api.sandbox.bridge.xyz/v0
        $apiKey = (string) config('bridge-rails.api_key');

        // sacamos el sufijo /v0 (o /v1) si existe
        $dashboardBase = preg_replace('~/v\d+$~', '', rtrim($base, '/'));
        $url = $dashboardBase . '/dashboard/generate_signed_agreement_id';

        $idempotencyKey = $idempotencyKey ?: (string) Str::uuid();

        $payload = [
            'customer_id' => $customerId ?: '',
            'type' => 'tos',
            'version' => $version,
        ];

        $resp = Http::timeout(20)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Api-Key' => $apiKey,
                'Idempotency-Key' => $idempotencyKey,
            ])
            ->post($url, $payload);

        $resp->throw();

        return $resp->json();
    }
}
