<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Link;

final class LinkClosure extends Link
{
    /**
     * @var callable
     */
    private $callable;

    public function __construct(callable $callable)
    {
        parent::__construct();
        $this->callable = $callable;
    }

    /**
     * Execute link.
     *
     * @param mixed $payload
     * @return mixed
     */
    public function execute($payload = null)
    {
        return call_user_func_array($this->callable, [$payload]);
    }
}
