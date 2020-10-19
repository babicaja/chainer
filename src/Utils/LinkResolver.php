<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Contracts\LinkResolver as LinkResolverContract;
use Chainer\Exceptions\NotCallable;
use Chainer\Exceptions\NotLinkInstance;
use Chainer\Exceptions\NotResolvable;
use Chainer\Exceptions\NotSupported;
use Chainer\Link;

final class LinkResolver implements LinkResolverContract
{
    /**
     * @param $link Link|callable|string
     * @return Link
     * @throws NotSupported
     * @throws NotCallable
     * @throws NotLinkInstance
     * @throws NotResolvable
     */
    public static function resolve($link): Link
    {
        if ($link instanceof Link) {
            return LinkFromLink::resolve($link);
        }

        if (is_callable($link)) {
            return LinkFromCallable::resolve($link);
        }

        if (is_string($link)) {
            return LinkFromString::resolve($link);
        }

        throw new NotSupported();
    }
}
