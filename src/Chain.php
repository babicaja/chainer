<?php

declare(strict_types=1);

namespace Chainer;

use BadMethodCallException;
use Chainer\Exceptions\NotSupported;
use Chainer\Utils\LinkResolver;

/**
 * Class Chain.
 *
 * @package Chainer
 * @method static Link do($link)
 */
final class Chain
{
    private Link $first;
    private Link $current;

    /**
     * Chain constructor.
     *
     * @param Link|callable|string $link
     * @throws Exceptions\NotCallable
     * @throws Exceptions\NotResolvable
     * @throws NotSupported
     */
    public function __construct($link)
    {
        $this->first = $this->current = LinkResolver::resolve($link);
    }

    /**
     * @throws Exceptions\NotCallable
     * @throws Exceptions\NotResolvable
     * @throws NotSupported
     */
    public static function __callStatic(string $name, iterable $arguments): Chain
    {
        if ($name !== 'do') {
            throw new BadMethodCallException();
        }

        return new self($arguments[0]);
    }

    /**
     * @param Link|callable|string $link
     */
    public function then($link): Chain
    {
        $this->current = $this->current->then($link);
        return $this;
    }

    /**
     * @param mixed $payload
     * @return mixed
     */
    public function run($payload = null)
    {
        return $this->first->run($payload);
    }
}
