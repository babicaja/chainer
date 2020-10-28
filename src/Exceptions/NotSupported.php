<?php

declare(strict_types=1);

namespace Chainer\Exceptions;

use Exception;
use Throwable;

final class NotSupported extends Exception
{
    /**
     * @param mixed $type
     */
    public function __construct($type, ?Throwable $previous = null)
    {
        $type = is_object($type) ? get_class($type) : gettype($type);
        parent::__construct("{$type} can't be linked", 300, $previous);
    }
}
