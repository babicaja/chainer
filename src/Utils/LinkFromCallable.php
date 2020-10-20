<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Link;

final class LinkFromCallable
{
    public static function resolve(callable $link): Link
    {
        return new LinkClosure($link);
    }
}
