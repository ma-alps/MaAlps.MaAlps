<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Exception;

use function in_array;

class RuntimeException extends \RuntimeException
{
    public function __construct()
    {
        $message = '';
        foreach ($this as $key => $value) { // @phpstan-ignore-line
            if (in_array($key, ['code', 'message', 'file', 'line'])) {
                continue;
            }

            $message .= "{$key}: {$value} ";
        }

        parent::__construct($message);
    }
}
