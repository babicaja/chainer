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
     * @throws NotResolvable
     * @throws NotCallable
     */
    public static function resolve(string $link): Link
    {
        $link = self::make($link);

        if ($link instanceof Link) {
            return $link;
        }

        self::check($link);
        return new LinkClosure($link);
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

    /**
     * @param mixed $link
     * @throws NotCallable
     */
    private static function check($link): void
    {
        if (!is_callable($link)) {
            throw new NotCallable(get_class($link));
        }
    }
}
