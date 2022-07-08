<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Exception;

class RuntimeException extends \RuntimeException
{
    public function __toString(): string
    {
        $message = '';
        foreach ($this as $key => $value) {
            $message .= "{$key}: {$value} ";
        }

        return $message;
    }
}
