<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\AppMeta\AbstractAppMeta;
use BEAR\Resource\ResourceObject;
use BEAR\Streamer\StreamTransferInject;
use Koriym\HttpConstants\StatusCode;

class StateDiagram extends ResourceObject
{
    use StreamTransferInject;

    public function __construct(
        private AbstractAppMeta $meta
    ){
    }

    public function onGet(string $profileFile): static
    {
        $svg = file_get_contents($this->meta->appDir . '/var/mock/blog/profile.svg');

        $outputPath = sprintf('%s/%s.profile.svg', $this->meta->tmpDir, \hash('sha256', $svg));
        file_put_contents($outputPath, $svg);
        $this->headers = [
            'Content-Location' => $outputPath
        ];
        $this->code = StatusCode::CREATED;
        return $this;
    }
}
