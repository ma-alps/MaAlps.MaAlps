<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

use function file_exists;

final class Created
{
    private function __construct(
        public readonly string $profileFile,
        public readonly string $dotFile,
        public readonly string $svgFile
    ) {
    }

    public static function fromProfile(string $profileFile): self
    {
        return new self(
            $profileFile,
            $profileFile . '.dot',
            $profileFile . '.svg'
        );
    }

    public function isCreated(): bool
    {
        return file_exists($this->dotFile) &&
            file_exists($this->profileFile) &&
            file_exists($this->svgFile);
    }
}
