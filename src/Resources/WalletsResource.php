<?php

namespace Aledaas\BridgeRails\Resources;

class WalletsResource extends BaseResource
{
    /**
     * GET /wallets
     *
     * Query params típicos (según docs):
     * - limit (int, default 10, max 100)
     * - starting_after (string wallet id)
     * - ending_before (string wallet id)
     */
    public function list(array $query = []): array
    {
        return $this->client->get('/wallets', $query);
    }

    /**
     * GET /wallets/total_balances
     *
     * Devuelve un array de balances totales por currency/chain/contract_address.
     * (En docs la response es un array, no objeto con {count,data}.)
     */
    public function totalBalances(array $query = []): array
    {
        return $this->client->get('/wallets/total_balances', $query);
    }

    /**
     * GET /wallets/{bridgeWalletID}/history
     *
     * Historial de movimientos de una bridge wallet.
     */
    public function history(string $bridgeWalletId, array $query = []): array
    {
        return $this->client->get("/wallets/{$bridgeWalletId}/history", $query);
    }

    /**
     * GET /customers/{customerID}/wallets
     *
     * Lista las bridge wallets asociadas a un customer.
     */
    public function listForCustomer(string $customerId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/wallets", $query);
    }

    /**
     * POST /customers/{customerID}/wallets
     *
     * Crea una bridge wallet para el customer.
     * Payload típico:
     * - chain: "base" | "solana" | etc.
     */
    public function createForCustomer(string $customerId, array $payload, ?string $idempotencyKey = null): array
    {
        return $this->client->post("/customers/{$customerId}/wallets", $payload, $idempotencyKey);
    }

    /**
     * GET /customers/{customerID}/wallets/{bridgeWalletID}
     *
     * Obtiene una wallet específica del customer, incluye balances.
     */
    public function getForCustomer(string $customerId, string $bridgeWalletId, array $query = []): array
    {
        return $this->client->get("/customers/{$customerId}/wallets/{$bridgeWalletId}", $query);
    }
}
