<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Alps;

use MaAlps\MaAlps\Attribute\AlpsDir;

use function file_put_contents;
use function md5;
use function mkdir;
use function sprintf;

final class Profile
{
    public function __construct(
        #[AlpsDir] private readonly string $alpsDir,
        private readonly DiagramInterface $diagram
    ) {
    }

    /**
     * @param string $profileFile ALPS profile raw data
     */
    public function put(string $profileFile): Created
    {
        $id = $this->getId($profileFile);
        $profilePath = sprintf('%s/%s/profile.%s', $this->alpsDir, $id, $this->getFileType($profileFile));
        @mkdir(sprintf('%s/%s', $this->alpsDir, $id));
        file_put_contents($profilePath, $profileFile);

        return $this->diagram->draw($profilePath);
    }

    private function getId(string $profile): string
    {
        return md5($profile);
    }

    private function getFileType(string $profile): string
    {
        return 'xml';
    }
}
