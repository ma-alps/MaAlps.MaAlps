<?php

declare(strict_types=1);

namespace MaAlps\MaAlps;

use MaAlps\MaAlps\Exception\DirectoryNotCreatedException;
use function is_dir;

function mkdir(string $directory): void
{
    if (! is_dir($directory) && !@\mkdir($directory) && ! is_dir($directory)) {
        throw new DirectoryNotCreatedException($directory);
    }
}
