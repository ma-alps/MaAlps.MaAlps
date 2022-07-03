<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\AppMeta\AbstractAppMeta;
use BEAR\Resource\ResourceObject;
use BEAR\Streamer\StreamTransferInject;
use Koriym\HttpConstants\StatusCode;
use MaAlps\MaAlps\Alps\DiagramInterface;
use RuntimeException;

use function fopen;

class StateDiagram extends ResourceObject
{
    use StreamTransferInject;

    /** @var array<string, string> */
    public $headers = ['Content-Type' => 'image/svg+xml'];

    public function __construct(
        private readonly AbstractAppMeta $meta,
        private readonly DiagramInterface $diagram
    ) {
    }

    public function onGet(string $profileFile = ''): static
    {
        $id = '1';
        $profile = $this->meta->appDir . '/var/mock/blog/profile.xml';
        $created = ($this->diagram)($profile, $id);
        $fp = fopen($created->svgFile, 'rb');
        if ($fp === false) {
            // @codeCoverageIgnoreStart
            throw new RuntimeException("failed to open file: {$profile}");
            // @codeCoverageIgnoreEnd
        }

        $this->body = $fp;

        $this->code = StatusCode::CREATED;

        return $this;
    }
}
