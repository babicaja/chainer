<?php

declare(strict_types=1);

namespace Chainer\Exceptions;

use Exception;
use Throwable;

final class NotCallable extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct("The class must be callable, implement the __invoke method", 100, $previous);
    }
}
