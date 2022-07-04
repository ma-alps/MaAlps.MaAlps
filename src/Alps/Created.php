<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Alps;

final class Created
{
    public function __construct(
        public readonly string $profileFile,
        public readonly string $dotFile,
        public readonly string $svgFile
    ) {
    }
}
