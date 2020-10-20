<?php

namespace Tests\Stubs;

use Chainer\Link;

class ResponseLinkTwo extends Link
{
    const RESPONSE = "LinkTwo Response";

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
