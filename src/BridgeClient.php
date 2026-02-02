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

    private function http(?string $idempotencyKey = null): PendingRequest
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

        if ($idempotencyKey) {
            $req = $req->withHeaders(['Idempotency-Key' => $idempotencyKey]);
        }

        return $req;
    }

    public function get(string $path, array $query = []): array
    {
        $resp = $this->http()->get($this->normalizePath($path), $query);
        return $this->handle($resp);
    }

    public function post(string $path, array $payload, ?string $idempotencyKey = null): array
    {
        $idempotencyKey ??= (string) Str::uuid();
        $resp = $this->http($idempotencyKey)->post($this->normalizePath($path), $payload);
        return $this->handle($resp);
    }

    public function postRaw(string $path, array $payload = [], ?string $idempotencyKey = null): string
    {
        $idempotencyKey ??= (string) Str::uuid();
        $resp = $this->http($idempotencyKey)->post($this->normalizePath($path), $payload);

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

    public function put(string $path, array $payload, ?string $idempotencyKey = null): array
    {
        $idempotencyKey ??= (string) Str::uuid();
        $resp = $this->http($idempotencyKey)->put($this->normalizePath($path), $payload);
        return $this->handle($resp);
    }

    public function delete(string $path, array $query = []): array
    {
        $resp = $this->http()->delete($this->normalizePath($path), $query);
        return $this->handle($resp);
    }

    public function patch(string $path, array $payload, ?string $idempotencyKey = null): array
    {
        $idempotencyKey ??= (string) \Illuminate\Support\Str::uuid();
        $resp = $this->http($idempotencyKey)->patch($this->normalizePath($path), $payload);
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
