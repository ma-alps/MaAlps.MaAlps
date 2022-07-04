<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

use MaAlps\MaAlps\Attribute\AlpsDir;

use function file_put_contents;
use function MaAlps\MaAlps\mkdir;
use function sprintf;

final class Profile
{
    public function __construct(
        #[AlpsDir] private readonly string $alpsDir,
        private readonly DiagramInterface $diagram,
        private readonly HashInterface $hash
    ) {
    }

    /**
     * @param string $profileFile ALPS profile raw data
     */
    public function put(string $profileFile): Created
    {
        $id = ($this->hash)($profileFile);
        $profilePath = sprintf('%s/%s/profile.%s', $this->alpsDir, $id, $this->getFileType($profileFile));
        $created = Created::fromProfile($profileFile);
        if ($created->isCreated()) {
            return $created;
        }

        mkdir(sprintf('%s/%s', $this->alpsDir, $id));
        file_put_contents($profilePath, $profileFile);

        return $this->diagram->draw($profilePath);
    }

    private function getFileType(string $profile): string
    {
        return 'xml';
    }
}
