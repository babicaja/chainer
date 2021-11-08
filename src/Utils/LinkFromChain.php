<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Chain;

final class LinkFromChain
{
    public static function resolve(Chain $link): LinkWrapper
    {
        return new LinkWrapper($link);
    }
}
