<?php

declare(strict_types=1);

namespace Chainer;

use Chainer\Exceptions\NotSupported;
use Chainer\Utils\LinkResolver;

abstract class Link
{
    private ?Link $link;

    public function __construct()
    {
        $this->link = null;
    }

    /**
     * Set the next link in the chain.
     *
     * @param $link Link|callable|string
     * @throws Exceptions\NotCallable
     * @throws Exceptions\NotResolvable
     * @throws Exceptions\NotLinkInstance
     * @throws NotSupported
     */
    public function then($link): Link
    {
        return $this->link = LinkResolver::resolve($link);
    }

    /**
     * Execute current link and run the next one if it is defined.
     *
     * @param null $payload
     * @return mixed
     */
    public function run($payload = null)
    {
        $result = $this->execute($payload);
        return $this->link ? $this->link->run($result) : $result;
    }

    /**
     * Execute link.
     *
     * @param mixed $payload
     * @return mixed
     */
    abstract public function execute($payload = null);

    /**
     * @param null $payload
     * @return mixed
     */
    public function __invoke($payload = null)
    {
        return $this->execute($payload);
    }
}
