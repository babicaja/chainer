<?php

declare(strict_types=1);

namespace Chainer\Contracts;

use Chainer\Link;

interface LinkResolver
{
    /**
     * @param $link Link|callable|string
     * @return Link
     */
    public static function resolve($link): Link;
}
