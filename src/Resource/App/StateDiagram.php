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

    public $headers = [
        'Content-Type' => 'image/svg+xml',
    ];

    public function __construct(
        private AbstractAppMeta $meta
    ){
    }

    public function onGet(string $profileFile): static
    {
        $filePath = $this->meta->appDir . '/var/mock/blog/profile.svg';
        $fp = fopen($filePath, 'rb');
        if ($fp === false) {
            throw new \RuntimeException("failed to open file: {$filePath}");
        }
        $this->body = $fp;

        $this->code = StatusCode::CREATED;
        return $this;
    }
}
