<?php

namespace Aledaas\BridgeRails\Webhooks;

use Aledaas\BridgeRails\Exceptions\WebhookSignatureException;

class BridgeWebhookVerifier
{
    public function __construct(
        private readonly string $publicKeyPem,
        private readonly int $toleranceSeconds = 600
    ) {}

    public function verify(string $signatureHeader, string $rawBody): void
    {
        [$timestampMs, $signatureB64] = $this->parseHeader($signatureHeader);
        $this->assertFreshTimestamp($timestampMs);

        $signedPayload = $timestampMs . '.' . $rawBody;

        $decodedSignature = base64_decode($signatureB64, true);
        if ($decodedSignature === false) {
            throw new WebhookSignatureException('Invalid base64 signature (v0).');
        }

        $publicKey = openssl_pkey_get_public($this->publicKeyPem);
        if ($publicKey === false) {
            throw new WebhookSignatureException('Invalid webhook public key PEM.');
        }

        $ok = openssl_verify($signedPayload, $decodedSignature, $publicKey, OPENSSL_ALGO_SHA256);
        openssl_free_key($publicKey);

        if ($ok !== 1) {
            throw new WebhookSignatureException('Webhook signature verification failed.');
        }
    }

    private function parseHeader(string $header): array
    {
        $parts = array_map('trim', explode(',', $header));
        $map = [];
        foreach ($parts as $p) {
            if (str_contains($p, '=')) {
                [$k, $v] = array_map('trim', explode('=', $p, 2));
                $map[$k] = $v;
            }
        }

        if (!isset($map['t'], $map['v0'])) {
            throw new WebhookSignatureException('Missing t or v0 in X-Webhook-Signature header.');
        }

        if (!ctype_digit($map['t'])) {
            throw new WebhookSignatureException('Invalid timestamp (t) in signature header.');
        }

        return [$map['t'], $map['v0']];
    }

    private function assertFreshTimestamp(string $timestampMs): void
    {
        $nowMs = (int) floor(microtime(true) * 1000);
        $ageSeconds = abs($nowMs - (int) $timestampMs) / 1000;

        if ($ageSeconds > $this->toleranceSeconds) {
            throw new WebhookSignatureException('Webhook timestamp outside tolerance window.');
        }
    }
}
