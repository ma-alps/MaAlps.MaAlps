<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\AppMeta\AbstractAppMeta;
use BEAR\Resource\ResourceObject;
use BEAR\Streamer\StreamTransferInject;
use Koriym\HttpConstants\StatusCode;
use MaAlps\MaAlps\Alps\DiagramInterface;
use MaAlps\MaAlps\Alps\StaticFile;
use RuntimeException;

use function fopen;
use function random_int;

class StateDiagram extends ResourceObject
{
    use StreamTransferInject;

    /** @var array<string, string> */
    public $headers = ['Content-Type' => 'image/svg+xml'];

    public function __construct(
        private readonly AbstractAppMeta $meta,
        private readonly DiagramInterface $diagram,
        private readonly StaticFile $staticFile
    ) {
    }

    public function onGet(string $profileFile = ''): static
    {
        $id = (string) random_int(1, 100);
        $profileFilePath = $this->staticFile->saveProfile($id, $profileFile);
        $created = ($this->diagram)($profileFilePath, $id);
        $fp = fopen($created->svgFile, 'rb');
        if ($fp === false) {
            // @codeCoverageIgnoreStart
            throw new RuntimeException("failed to open file: {$profileFilePath}");
            // @codeCoverageIgnoreEnd
        }

        $this->body = $fp;

        $this->code = StatusCode::CREATED;

        return $this;
    }
}
