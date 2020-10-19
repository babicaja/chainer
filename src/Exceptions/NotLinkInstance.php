<?php

declare(strict_types=1);

namespace Chainer\Exceptions;

use Exception;
use Throwable;

final class NotLinkInstance extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct("This is not a Link instance", 200, $previous);
    }
}
