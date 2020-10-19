<?php

namespace Tests\Stubs;

use Chainer\Link;

class ResponseLinkOne extends Link
{
    const RESPONSE = "LinkOne response";

    /**
     * Execute link.
     *
     * @param $payload
     * @return mixed
     */
    public function execute($payload = null)
    {
        if (is_null($payload)) {
            $payload = "";
        }
        return $payload . self::RESPONSE;
    }
}
