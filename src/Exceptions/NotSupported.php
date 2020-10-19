<?php

declare(strict_types=1);

namespace Chainer\Exceptions;

use Exception;
use Throwable;

final class NotSupported extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct("The provided argument is not supported", 400, $previous);
    }
}
