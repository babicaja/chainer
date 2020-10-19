<?php

namespace Tests\Stubs;

use Chainer\Link;

class ResponseLinkTwo extends Link
{
    const RESPONSE = "LinkTwo Response";

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
