<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Contracts\LinkResolver;
use Chainer\Exceptions\NotLinkInstance;
use Chainer\Link;

final class LinkFromLink implements LinkResolver
{
    /**
     * @param $link
     * @throws NotLinkInstance
     */
    public static function resolve($link): Link
    {
        self::check($link);
        return $link;
    }

    /**
     * @param $link
     * @throws NotLinkInstance
     */
    private static function check($link): void
    {
        if (!$link instanceof Link) {
            throw new NotLinkInstance();
        }
    }
}
