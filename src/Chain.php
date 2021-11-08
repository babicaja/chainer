<?php

declare(strict_types=1);

namespace Chainer;

use BadMethodCallException;
use Chainer\Exceptions\NotCallable;
use Chainer\Exceptions\NotResolvable;
use Chainer\Utils\LinkResolver;
use Chainer\Utils\LinkWrapper;

/**
 * Class Chain.
 *
 * @package Chainer
 * @method static Chain do(Chain|callable|string $link) Set the first link in the chain.
 */
final class Chain
{
    private LinkWrapper $first;
    private LinkWrapper $current;

    /**
     * Set the first link in the chain.
     *
     * @throws NotCallable
     * @throws NotResolvable
     */
    public function __construct(Chain|callable|string $link)
    {
        $this->first = $this->current = LinkResolver::resolve($link);
    }

    /**
     * Set the next link in the chain.
     *
     * @throws NotCallable
     * @throws NotResolvable
     */
    public function then(Chain|callable|string $link): Chain
    {
        $this->current = $this->current->then($link);
        return $this;
    }

    /**
     * Execute all the links in the chain.
     */
    public function run(mixed $payload = null): mixed
    {
        return $this->first->run($payload);
    }

    /**
     * Execute all the links in the chain.
     */
    public function __invoke(mixed $payload = null): mixed
    {
        return $this->first->run($payload);
    }

    /**
     * @throws NotResolvable
     * @throws NotCallable
     */
    public static function __callStatic(string $name, array $arguments): Chain
    {
        if ($name !== 'do') {
            throw new BadMethodCallException();
        }

        return new self($arguments[0]);
    }
}
