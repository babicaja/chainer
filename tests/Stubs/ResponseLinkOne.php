<?php

namespace Tests\Stubs;

use Chainer\Link;

class ResponseLinkOne extends Link
{
    public const RESPONSE = "LinkOne response";

    /**
     * Handle payload.
     *
     * @param mixed $payload
     * @return mixed
     */
    public function handle($payload = null)
    {
        $payload[__CLASS__] = self::RESPONSE;
        return $payload;
    }
}
