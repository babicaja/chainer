<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Chain;
use Chainer\Exceptions\NotCallable;
use Chainer\Exceptions\NotResolvable;

final class LinkResolver
{
    /**
     * @throws NotResolvable
     * @throws NotCallable
     */
    public static function resolve(Chain|callable|string $link): LinkWrapper
    {
        if ($link instanceof Chain) {
            return LinkFromChain::resolve($link);
        }

        if (is_callable($link)) {
            return LinkFromCallable::resolve($link);
        }

        return LinkFromString::resolve($link);
    }
}
