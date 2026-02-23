<?php

namespace Aledaas\BridgeRails;

use Aledaas\BridgeRails\Exceptions\BridgeApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BridgeClient
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey,
        private readonly string $apiPrefix = '/v0',
        private readonly int $timeoutSeconds = 30,
        private readonly int $retries = 2,
        private readonly int $retrySleepMs = 200,
    ) {}

    private function http(string $method = 'GET', ?string $idempotencyKey = null): PendingRequest
    {
        $base = rtrim($this->baseUrl, '/');
        $prefix = '/' . ltrim($this->apiPrefix, '/');

        $req = Http::baseUrl($base . $prefix)
            ->withHeaders([
                'Api-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ])
            ->timeout($this->timeoutSeconds)
            ->retry($this->retries, $this->retrySleepMs);

        $methodUpper = strtoupper($method);

        // Bridge: Idempotency-Key solo para POST (creación).
        if (!empty($idempotencyKey) && $methodUpper === 'POST') {
            $req = $req->withHeaders(['Idempotency-Key' => $idempotencyKey]);
        }

        return $req;
    }

    private function httpNoPrefix(string $method = 'GET', ?string $idempotencyKey = null): PendingRequest
    {
        $base = rtrim($this->baseUrl, '/');

        $req = Http::baseUrl($base)
            ->withHeaders([
                'Api-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ])
            ->timeout($this->timeoutSeconds)
            ->retry($this->retries, $this->retrySleepMs);

        $methodUpper = strtoupper($method);

        if (!empty($idempotencyKey) && $methodUpper === 'POST') {
            $req = $req->withHeaders(['Idempotency-Key' => $idempotencyKey]);
        }

        return $req;
    }

    public function postNoPrefix(string $path, array $payload, ?string $idempotencyKey = null): array
    {
        $idempotencyKey ??= (string) Str::uuid();
        $resp = $this->httpNoPrefix('POST', $idempotencyKey)->post($this->normalizePath($path), $payload);
        return $this->handle($resp);
    }

    public function getNoPrefix(string $path, array $query = []): array
    {
        $resp = $this->httpNoPrefix('GET')->get($this->normalizePath($path), $query);
        return $this->handle($resp);
    }

    public function get(string $path, array $query = []): array
    {
        $resp = $this->http('GET')->get($this->normalizePath($path), $query);
        return $this->handle($resp);
    }

    public function post(string $path, array $payload, ?string $idempotencyKey = null): array
    {
        $idempotencyKey ??= (string) Str::uuid();
        $resp = $this->http('POST', $idempotencyKey)->post($this->normalizePath($path), $payload);
        return $this->handle($resp);
    }

    public function postRaw(string $path, array $payload = [], ?string $idempotencyKey = null): string
    {
        $idempotencyKey ??= (string) Str::uuid();
        $resp = $this->http('POST', $idempotencyKey)->post($this->normalizePath($path), $payload);

        if ($resp->successful()) {
            return (string) $resp->body();
        }

        $body = $resp->json();
        $message = is_array($body) ? json_encode($body) : (string) $resp->body();

        throw new BridgeApiException(
            message: "Bridge API error ({$resp->status()}): {$message}",
            status: $resp->status(),
            responseBody: $body
        );
    }

    public function put(string $path, array $payload): array
    {
        $resp = $this->http('PUT')->put($this->normalizePath($path), $payload);
        return $this->handle($resp);
    }

    public function delete(string $path, array $query = []): array
    {
        $resp = $this->http('DELETE')->delete($this->normalizePath($path), $query);
        return $this->handle($resp);
    }

    // ❗ PATCH sin Idempotency-Key
    public function patch(string $path, array $payload): array
    {
        $resp = $this->http('PATCH')->patch($this->normalizePath($path), $payload);
        return $this->handle($resp);
    }

    private function normalizePath(string $path): string
    {
        return '/' . ltrim(trim($path), '/');
    }

    private function handle(Response $resp): array
    {
        if ($resp->successful()) {
            return $resp->json() ?? [];
        }

        $body = $resp->json();
        $message = is_array($body) ? json_encode($body) : (string) $resp->body();

        throw new BridgeApiException(
            message: "Bridge API error ({$resp->status()}): {$message}",
            status: $resp->status(),
            responseBody: $body
        );
    }
}
