<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Chain;
use Chainer\Exceptions\NotCallable;
use Chainer\Exceptions\NotResolvable;

final class LinkWrapper
{
    private LinkWrapper $next;

    /** @var Chain | callable */
    private $callable;

    public function __construct(Chain|callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * Set the next link in the chain.
     *
     * @throws NotResolvable
     * @throws NotCallable
     */
    public function then(Chain|callable|string $link): LinkWrapper
    {
        return $this->next = LinkResolver::resolve($link);
    }

    /**
     * Execute current link and run the next one if it is defined.
     */
    public function run(mixed $payload = null): mixed
    {
        $result = $this->handle($payload) ?: $payload;
        return isset($this->next) ? $this->next->run($result) : $result;
    }

    /**
     * Execute the callable.
     */
    public function handle(mixed $payload = null): mixed
    {
        return call_user_func_array($this->callable, [$payload]);
    }
}
