<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Exception;

class DiagramCreateFailedException extends RuntimeException
{
    public function __construct(
        public readonly string $profileFilePath
    ) {
        parent::__construct();
    }
}
