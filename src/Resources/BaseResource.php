<?php

namespace Aledaas\BridgeRails\Resources;

use Aledaas\BridgeRails\BridgeClient;

abstract class BaseResource
{
    public function __construct(protected readonly BridgeClient $client) {}
}
