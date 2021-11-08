<?php

declare(strict_types=1);

namespace Chainer\Utils;

final class LinkFromCallable
{
    public static function resolve(callable $link): LinkWrapper
    {
        return new LinkWrapper($link);
    }
}
