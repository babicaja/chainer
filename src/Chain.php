<?php

declare(strict_types=1);

namespace Chainer;

use BadMethodCallException;
use Chainer\Exceptions\NotCallable;
use Chainer\Exceptions\NotResolvable;
use Chainer\Exceptions\NotSupported;
use Chainer\Utils\LinkResolver;

/**
 * Class Chain.
 *
 * @package Chainer
 * @method static Chain do(Link|Chain|callable|string $link) Set the first link in the chain.
 */
final class Chain
{
    /** @var Link */
    private Link $first;
    /** @var Link */
    private Link $current;

    /**
     * Set the first link in the chain.
     *
     * @param Link|Chain|callable|string $link
     * @throws NotCallable
     * @throws NotResolvable
     * @throws NotSupported
     */
    public function __construct($link)
    {
        $this->first = $this->current = LinkResolver::resolve($link);
    }

    /**
     * @throws NotResolvable
     * @throws NotSupported
     * @throws NotCallable
     */
    public static function __callStatic(string $name, array $arguments): Chain
    {
        if ($name !== 'do') {
            throw new BadMethodCallException();
        }

        return new self($arguments[0]);
    }

    /**
     * Execute all links in the chain.
     *
     * @param mixed $payload
     * @return mixed
     */
    public function __invoke($payload = null)
    {
        return $this->first->run($payload);
    }

    /**
     * Set the next link in the chain.
     *
     * @param Link|Chain|callable|string $link
     * @throws NotCallable
     * @throws NotResolvable
     * @throws NotSupported
     */
    public function then($link): Chain
    {
        $this->current = $this->current->then($link);
        return $this;
    }

    /**
     * Execute all links in the chain.
     *
     * @param mixed $payload
     * @return mixed
     */
    public function run($payload = null)
    {
        return $this->first->run($payload);
    }
}
