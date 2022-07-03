<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Alps;

use MaAlps\MaAlps\Attribute\AlpsDir;

use function file_put_contents;
use function sprintf;

final class StaticFile
{
    public function __construct(
        #[AlpsDir] private readonly string $alpsDir
    ) {
    }

    public function saveProfile(string $id, string $profile, string $ext = 'xml'): string
    {
        $file = sprintf('%s/profile.%s.%s', $this->alpsDir, $id, $ext);
        file_put_contents($file, $profile);

        return $file;
    }
}
