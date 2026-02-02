<?php

namespace Aledaas\BridgeRails;

use Aledaas\BridgeRails\Resources\{BalancesResource,
    CryptoReturnPoliciesResource,
    CustomersResource,
    DrainsResource,
    ExternalAccountsResource,
    FeesResource,
    IssuanceResource,
    LiquidationAddressesResource,
    PlaidResource,
    PrefundedAccountsResource,
    RewardsResource,
    StaticMemosResource,
    TransfersResource,
    VirtualAccountsResource,
    WalletsResource,
    WebhooksResource,
    DevelopersResource,
    ExchangeRatesResource,
    BatchSettlementSchedulesResource,
    FundsRequestsResource};

class Bridge
{
    public function __construct(private readonly BridgeClient $client) {}

    public function customers(): CustomersResource { return new CustomersResource($this->client); }
    public function externalAccounts(): ExternalAccountsResource { return new ExternalAccountsResource($this->client); }
    public function transfers(): TransfersResource { return new TransfersResource($this->client); }
    public function wallets(): WalletsResource { return new WalletsResource($this->client); }
    public function balances(): BalancesResource { return new BalancesResource($this->client); }
    public function fees(): FeesResource { return new FeesResource($this->client); }
    public function liquidationAddresses(): LiquidationAddressesResource { return new LiquidationAddressesResource($this->client); }
    public function virtualAccounts(): VirtualAccountsResource { return new VirtualAccountsResource($this->client); }
    public function prefundedAccounts(): PrefundedAccountsResource { return new PrefundedAccountsResource($this->client); }
    public function drains(): DrainsResource { return new DrainsResource($this->client); }
    public function webhooks(): WebhooksResource { return new WebhooksResource($this->client); }
    public function issuance(): IssuanceResource { return new IssuanceResource($this->client); }
    public function plaid(): PlaidResource { return new PlaidResource($this->client); }
    public function staticMemos(): StaticMemosResource { return new StaticMemosResource($this->client); }
    public function developers(): DevelopersResource { return new DevelopersResource($this->client); }
    public function exchangeRates(): ExchangeRatesResource { return new ExchangeRatesResource($this->client); }
    public function batchSettlementSchedules(): BatchSettlementSchedulesResource { return new BatchSettlementSchedulesResource($this->client); }
    public function fundsRequests(): FundsRequestsResource { return new FundsRequestsResource($this->client); }
    public function cryptoReturnPolicies(): CryptoReturnPoliciesResource { return new CryptoReturnPoliciesResource($this->client);}
    public function rewards(): RewardsResource { return new RewardsResource($this->client); }
}
