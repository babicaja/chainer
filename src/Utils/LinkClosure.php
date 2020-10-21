<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Link;

final class LinkClosure extends Link
{
    /** @var callable */
    private $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * Handle payload.
     *
     * @param mixed $payload
     * @return mixed
     */
    public function handle($payload = null)
    {
        return call_user_func_array($this->callable, [$payload]);
    }
}
