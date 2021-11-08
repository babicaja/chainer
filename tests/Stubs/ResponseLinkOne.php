<?php

namespace Tests\Stubs;

class ResponseLinkOne
{
    public const RESPONSE = "LinkOne response";

    public function __invoke(mixed $payload = null): mixed
    {
        $payload[__CLASS__] = self::RESPONSE;
        return $payload;
    }
}
