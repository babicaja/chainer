<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Contracts\LinkResolver;
use Chainer\Exceptions\NotCallable;
use Chainer\Link;

final class LinkFromCallable implements LinkResolver
{
    /**
     * @param $link
     * @return Link
     * @throws NotCallable
     */
    public static function resolve($link): Link
    {
        self::check($link);
        return new LinkClosure($link);
    }

    /**
     * @param $link
     * @throws NotCallable
     */
    private static function check($link): void
    {
        if (!is_callable($link)) {
            throw new NotCallable();
        }
    }
}
