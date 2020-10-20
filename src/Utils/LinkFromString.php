<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Exceptions\NotCallable;
use Chainer\Exceptions\NotResolvable;
use Chainer\Link;
use Throwable;

final class LinkFromString
{
    /**
     * @throws NotCallable
     * @throws NotResolvable
     */
    public static function resolve(string $link): Link
    {
        $link = self::make($link);
        self::check($link);

        return $link instanceof Link ? $link : new LinkClosure($link);
    }

    /**
     * @throws NotResolvable
     * @return mixed
     */
    private static function make(string $link)
    {
        if (!class_exists($link)) {
            throw new NotResolvable($link);
        }

        try {
            return new $link();
        } catch (Throwable $throwable) {
            throw new NotResolvable($link, $throwable);
        }
    }

    /**
     * @param Link|callable|string $link
     * @throws NotCallable
     */
    private static function check($link): void
    {
        if (!is_callable($link)) {
            throw new NotCallable();
        }
    }
}
