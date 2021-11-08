<?php

namespace Tests\Stubs;

class PayloadLink
{
    public function __invoke(mixed $payload): mixed
    {
        return $payload;
    }
}
