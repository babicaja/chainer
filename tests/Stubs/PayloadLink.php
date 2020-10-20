<?php

namespace Tests\Stubs;

use Chainer\Link;

class PayloadLink extends Link
{
    /**
     * Execute link.
     *
     * @param $payload
     * @return mixed
     */
    public function handle($payload = null)
    {
        return $payload;
    }
}
