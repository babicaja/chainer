<?php

declare(strict_types=1);

namespace Chainer\Exceptions;

use Exception;
use Throwable;

final class NotResolvable extends Exception
{
    public function __construct(string $class = 'class', ?Throwable $previous = null)
    {
        parent::__construct("{$class} in not resolvable", 200, $previous);
    }
}
