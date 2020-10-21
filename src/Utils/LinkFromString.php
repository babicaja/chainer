<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Exceptions\NotResolvable;
use Chainer\Link;
use Throwable;

final class LinkFromString
{
    /**
     * @throws NotResolvable
     */
    public static function resolve(string $link): Link
    {
        $link = self::make($link);
        return $link instanceof Link ? $link : new LinkClosure($link);
    }

    /**
     * @return mixed
     * @throws NotResolvable
     */
    private static function make(string $link)
    {
        try {
            return new $link();
        } catch (Throwable $throwable) {
            throw new NotResolvable($link, $throwable);
        }
    }
}
