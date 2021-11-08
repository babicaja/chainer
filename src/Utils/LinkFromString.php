<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Chain;
use Chainer\Exceptions\NotCallable;
use Chainer\Exceptions\NotResolvable;
use Throwable;

final class LinkFromString
{
    /**
     * @throws NotResolvable
     * @throws NotCallable
     */
    public static function resolve(string $link): LinkWrapper
    {
        try {
            $resolved = new $link();
        } catch (Throwable $throwable) {
            throw new NotResolvable($link, $throwable);
        }

        if ($resolved instanceof Chain) {
            return LinkFromChain::resolve($resolved);
        }

        if (is_callable($resolved)) {
            return LinkFromCallable::resolve($resolved);
        }

        throw new NotCallable($link);
    }
}
