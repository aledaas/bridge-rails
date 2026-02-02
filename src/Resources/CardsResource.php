<?php

namespace Aledaas\BridgeRails\Resources;

class CardsResource extends BaseResource
{
    /**
     * Create Card PIN Update URL
     * POST /customers/{customerID}/card_accounts/{cardAccountID}/pin
     */
    public function createPinUpdateUrl(string $customerId, string $cardAccountId, ?string $idempotencyKey = null): array
    {
        return $this->client->post(
            "/customers/{$customerId}/card_accounts/{$cardAccountId}/pin",
            payload: [],
            idempotencyKey: $idempotencyKey
        );
    }

    /**
     * Generate an Ephemeral Key to Reveal Card Details
     * POST /customers/{customerID}/card_accounts/{cardAccountID}/ephemeral_keys
     */
    public function createEphemeralKey(string $customerId, string $cardAccountId, string $clientNonce, ?string $idempotencyKey = null): array
    {
        return $this->client->post(
            "/customers/{$customerId}/card_accounts/{$cardAccountId}/ephemeral_keys",
            payload: ['client_nonce' => $clientNonce],
            idempotencyKey: $idempotencyKey
        );
    }

    /**
     * Get a summary of your card program
     * GET /developer/cards/summary
     *
     * Nota: En el doc dice "optionally for a specific period".
     * Si Bridge soporta query params, los pasamos.
     */
    public function getProgramSummary(?string $period = null, ?string $periodStarting = null): array
    {
        $query = array_filter([
            'period' => $period,
            'period_starting' => $periodStarting,
        ], fn ($v) => $v !== null && $v !== '');

        return $this->client->get("/developer/cards/summary", $query);
    }

    /**
     * Get a listing of your card program's card designs
     * GET /developer/cards/designs
     */
    public function getCardDesigns(): array
    {
        return $this->client->get("/developer/cards/designs");
    }

    /**
     * Retrieve a card account
     * GET /customers/{customerID}/card_accounts/{cardAccountID}
     */
    public function getCardAccount(string $customerId, string $cardAccountId): array
    {
        return $this->client->get("/customers/{$customerId}/card_accounts/{$cardAccountId}");
    }

    /**
     * Get all card accounts (by customer)
     * GET /customers/{customerID}/card_accounts
     *
     * (Los ejemplos no muestran paginación explícita, pero algunos endpoints de Bridge usan page/pagination_token.)
     */
    public function listCardAccountsByCustomer(string $customerId, ?int $page = null, ?string $paginationToken = null): array
    {
        $query = array_filter([
            'page' => $page,
            'pagination_token' => $paginationToken,
        ], fn ($v) => $v !== null && $v !== '');

        return $this->client->get("/customers/{$customerId}/card_accounts", $query);
    }

    /**
     * Provision a card account
     * POST /customers/{customerID}/card_accounts
     */
    public function provisionCardAccount(
        string $customerId,
        string $currency,
        string $chain,
        string $clientReferenceId,
        array $cryptoAccount,
        ?string $cardDesignShortname = null,
        ?string $idempotencyKey = null
    ): array {
        $payload = array_filter([
            'currency' => $currency,
            'chain' => $chain,
            'client_reference_id' => $clientReferenceId,
            'crypto_account' => $cryptoAccount,
            'card_design_shortname' => $cardDesignShortname,
        ], fn ($v) => $v !== null && $v !== '');

        return $this->client->post(
            "/customers/{$customerId}/card_accounts",
            payload: $payload,
            idempotencyKey: $idempotencyKey
        );
    }

    /**
     * Place a freeze on the card account
     * POST /customers/{customerID}/card_accounts/{cardAccountID}/freeze
     */
    public function freezeCardAccount(
        string $customerId,
        string $cardAccountId,
        string $initiator,
        string $reason,
        ?string $reasonDetail = null,
        ?string $startingAt = null,
        ?string $endingAt = null,
        ?string $idempotencyKey = null
    ): array {
        $payload = array_filter([
            'initiator' => $initiator,      // developer | customer ?
            'reason' => $reason,            // lost_or_stolen, etc.
            'reason_detail' => $reasonDetail,
            'starting_at' => $startingAt,
            'ending_at' => $endingAt,
        ], fn ($v) => $v !== null && $v !== '');

        return $this->client->post(
            "/customers/{$customerId}/card_accounts/{$cardAccountId}/freeze",
            payload: $payload,
            idempotencyKey: $idempotencyKey
        );
    }

    /**
     * Unfreeze the card account
     * POST /customers/{customerID}/card_accounts/{cardAccountID}/unfreeze
     */
    public function unfreezeCardAccount(
        string $customerId,
        string $cardAccountId,
        string $initiator,
        ?string $idempotencyKey = null
    ): array {
        return $this->client->post(
            "/customers/{$customerId}/card_accounts/{$cardAccountId}/unfreeze",
            payload: ['initiator' => $initiator],
            idempotencyKey: $idempotencyKey
        );
    }

    /**
     * Create a mobile wallet push provisioning request
     * POST /customers/{customerID}/card_accounts/{cardAccountID}/create_mobile_wallet_provisioning_request
     */
    public function createMobileWalletProvisioningRequest(
        string $customerId,
        string $cardAccountId,
        string $walletProvider, // apple_pay | google_pay
        array $applePay = [],
        array $googlePay = [],
        ?string $idempotencyKey = null
    ): array {
        $payload = [
            'wallet_provider' => $walletProvider,
        ];

        // Solo incluimos el bloque que corresponda para no mandar basura.
        if ($walletProvider === 'apple_pay') {
            $payload['apple_pay'] = $applePay;
        }

        if ($walletProvider === 'google_pay') {
            $payload['google_pay'] = $googlePay;
        }

        return $this->client->post(
            "/customers/{$customerId}/card_accounts/{$cardAccountId}/create_mobile_wallet_provisioning_request",
            payload: $payload,
            idempotencyKey: $idempotencyKey
        );
    }

    /**
     * Retrieve pending card authorizations (no paginated)
     * GET /customers/{customerID}/card_accounts/{cardAccountID}/authorizations
     */
    public function listPendingAuthorizations(string $customerId, string $cardAccountId): array
    {
        return $this->client->get("/customers/{$customerId}/card_accounts/{$cardAccountId}/authorizations");
    }

    /**
     * Retrieve card transactions
     * GET /customers/{customerID}/card_accounts/{cardAccountID}/transactions
     */
    public function listTransactions(
        string $customerId,
        string $cardAccountId,
        ?int $page = null,
        ?string $paginationToken = null
    ): array {
        $query = array_filter([
            'page' => $page,
            'pagination_token' => $paginationToken,
        ], fn ($v) => $v !== null && $v !== '');

        return $this->client->get("/customers/{$customerId}/card_accounts/{$cardAccountId}/transactions", $query);
    }

    /**
     * Get a card transaction
     * GET /customers/{customerID}/card_accounts/{cardAccountID}/transactions/{transactionID}
     */
    public function getTransaction(string $customerId, string $cardAccountId, string $transactionId): array
    {
        return $this->client->get("/customers/{$customerId}/card_accounts/{$cardAccountId}/transactions/{$transactionId}");
    }

    /**
     * Get auth controls (spending limits, etc.)
     * GET /customers/{customerID}/card_accounts/{cardAccountID}/auth_controls
     */
    public function getAuthControls(string $customerId, string $cardAccountId): array
    {
        return $this->client->get("/customers/{$customerId}/card_accounts/{$cardAccountId}/auth_controls");
    }

    /**
     * Provision an additional top-up deposit address for the card account
     * POST /customers/{customerID}/card_accounts/{cardAccountID}/deposit_addresses
     */
    public function provisionAdditionalDepositAddress(
        string $customerId,
        string $cardAccountId,
        string $chain,
        ?string $idempotencyKey = null
    ): array {
        return $this->client->post(
            "/customers/{$customerId}/card_accounts/{$cardAccountId}/deposit_addresses",
            payload: ['chain' => $chain],
            idempotencyKey: $idempotencyKey
        );
    }

    /**
     * List withdrawals (top-up accounts)
     * GET /customers/{customerID}/card_accounts/{cardAccountID}/withdrawals
     */
    public function listWithdrawals(string $customerId, string $cardAccountId, ?int $page = null): array
    {
        $query = array_filter(['page' => $page], fn ($v) => $v !== null && $v !== '');
        return $this->client->get("/customers/{$customerId}/card_accounts/{$cardAccountId}/withdrawals", $query);
    }

    /**
     * Create a funds withdrawal request (top-up accounts)
     * POST /customers/{customerID}/card_accounts/{cardAccountID}/withdrawals
     */
    public function createWithdrawal(
        string $customerId,
        string $cardAccountId,
        string $amount,
        array $destination,
        string $type = 'top_up_balance_withdrawal',
        ?string $clientNote = null,
        ?string $idempotencyKey = null
    ): array {
        $payload = array_filter([
            'amount' => $amount,
            'destination' => $destination,
            'type' => $type,
            'client_note' => $clientNote,
        ], fn ($v) => $v !== null && $v !== '');

        return $this->client->post(
            "/customers/{$customerId}/card_accounts/{$cardAccountId}/withdrawals",
            payload: $payload,
            idempotencyKey: $idempotencyKey
        );
    }

    /**
     * Get a withdrawal request
     * GET /customers/{customerID}/card_accounts/{cardAccountID}/withdrawals/{cardWithdrawalID}
     */
    public function getWithdrawal(string $customerId, string $cardAccountId, string $cardWithdrawalId): array
    {
        return $this->client->get("/customers/{$customerId}/card_accounts/{$cardAccountId}/withdrawals/{$cardWithdrawalId}");
    }

    /**
     * Generate a card account statement (PDF)
     * POST /customers/{customerID}/card_accounts/{cardAccountID}/statements/{period}.pdf
     *
     * OJO: esto NO vuelve JSON en general (vuelve un string/pdf).
     * Con el BridgeClient actual (handle() => json()) esto no va a funcionar bien.
     */
    public function generateStatementPdf(string $customerId, string $cardAccountId, string $period, ?string $idempotencyKey = null): string
    {
        return $this->client->postRaw(
            "/customers/{$customerId}/card_accounts/{$cardAccountId}/statements/{$period}.pdf",
            payload: [],
            idempotencyKey: $idempotencyKey
        );
    }
}
