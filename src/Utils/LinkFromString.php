<?php

declare(strict_types=1);

namespace Chainer\Utils;

use Chainer\Contracts\LinkResolver;
use Chainer\Exceptions\NotCallable;
use Chainer\Exceptions\NotResolvable;
use Chainer\Link;
use Throwable;

final class LinkFromString implements LinkResolver
{
    /**
     * @param $link
     * @throws NotCallable
     * @throws NotResolvable
     */
    public static function resolve($link): Link
    {
        $link = self::make($link);
        self::check($link);

        return $link instanceof Link ? $link : new LinkClosure($link);
    }

    /**
     * @param string $link
     * @return mixed
     * @throws NotResolvable
     */
    private static function make(string $link)
    {
        if (!class_exists($link)) {
            throw new NotResolvable();
        }

        try {
            return new $link();
        } catch (Throwable $throwable) {
            throw new NotResolvable($throwable);
        }
    }

    /**
     * @param $link
     * @throws NotCallable
     */
    private static function check($link): void
    {
        if (!is_callable($link)) {
            throw new NotCallable();
        }
    }
}
