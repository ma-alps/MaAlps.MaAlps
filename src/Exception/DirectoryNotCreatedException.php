<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Exception;

class DirectoryNotCreatedException extends RuntimeException
{
    public function __construct(
        public string $directory
    ) {
        parent::__construct();
    }
}
