<?php

declare(strict_types=1);

namespace Chainer;

use Chainer\Exceptions\NotSupported;
use Chainer\Utils\LinkResolver;

abstract class Link
{
    /** @var Link */
    private Link $next;

    /**
     * Set the next link in the chain.
     *
     * @param Link|callable|string $link
     * @throws Exceptions\NotResolvable
     * @throws NotSupported
     */
    public function then($link): Link
    {
        return $this->next = LinkResolver::resolve($link);
    }

    /**
     * Execute current link and run the next one if it is defined.
     *
     * @param mixed $payload
     * @return mixed
     */
    public function run($payload = null)
    {
        $result = $this->handle($payload) ?: $payload;
        return isset($this->next) ? $this->next->run($result) : $result;
    }

    /**
     * Handle payload.
     *
     * @param mixed $payload
     * @return mixed
     */
    abstract public function handle($payload = null);
}
