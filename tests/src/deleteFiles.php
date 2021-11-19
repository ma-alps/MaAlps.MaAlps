<?php

declare(strict_types=1);

function deleteFiles(string $path): void
{
    foreach (array_filter((array) glob($path . '/*')) as $file) {
        is_dir($file) ? deleteFiles($file) : unlink($file);
        @rmdir($file);
    }
}
