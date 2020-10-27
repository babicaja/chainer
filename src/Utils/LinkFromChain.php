<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Chain;
use Chainer\Link;

final class LinkFromChain
{
    public static function resolve(Chain $link): Link
    {
        return new LinkClosure($link);
    }
}
