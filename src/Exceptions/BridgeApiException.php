<?php

namespace Aledaas\BridgeRails\Exceptions;

use RuntimeException;

class BridgeApiException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly int $status,
        public readonly mixed $responseBody = null
    ) {
        parent::__construct($message, $status);
    }
}
