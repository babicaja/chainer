<?php

declare(strict_types=1);

namespace Chainer\Exceptions;

use Exception;
use Throwable;

final class NotResolvable extends Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct("The FQN in not resolvable", 300, $previous);
    }
}
