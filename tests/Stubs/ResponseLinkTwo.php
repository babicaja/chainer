<?php

namespace Tests\Stubs;

class ResponseLinkTwo
{
    public const RESPONSE = "LinkTwo Response";

    public function __invoke(mixed $payload = null): mixed
    {
        $payload[__CLASS__] = self::RESPONSE;
        return $payload;
    }
}
