<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Link;

final class LinkFromLink
{
    public static function resolve(Link $link): Link
    {
        return $link;
    }
}
