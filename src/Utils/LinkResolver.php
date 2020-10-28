<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Chain;
use Chainer\Exceptions\NotCallable;
use Chainer\Exceptions\NotResolvable;
use Chainer\Exceptions\NotSupported;
use Chainer\Link;

final class LinkResolver
{
    /**
     * @param Link|callable|string $link
     * @throws NotResolvable
     * @throws NotSupported
     * @throws NotCallable
     */
    public static function resolve($link): Link
    {
        if ($link instanceof Chain) {
            return LinkFromChain::resolve($link);
        }

        if ($link instanceof Link) {
            return LinkFromLink::resolve($link);
        }

        if (is_callable($link)) {
            return LinkFromCallable::resolve($link);
        }

        if (is_string($link)) {
            return LinkFromString::resolve($link);
        }

        throw new NotSupported($link);
    }
}
