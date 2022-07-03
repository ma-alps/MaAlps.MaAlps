<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\ResourceObject;
use BEAR\Streamer\StreamTransferInject;
use Koriym\HttpConstants\StatusCode;
use MaAlps\MaAlps\Alps\DiagramInterface;
use MaAlps\MaAlps\Alps\StaticFile;
use MaAlps\MaAlps\Exception\DiagramCreateFailedException;

use function fopen;
use function random_int;

class StateDiagram extends ResourceObject
{
    use StreamTransferInject;

    /** @var array<string, string> */
    public $headers = ['Content-Type' => 'image/svg+xml'];

    public function __construct(
        private readonly DiagramInterface $diagram,
        private readonly StaticFile $staticFile
    ) {
    }

    public function onGet(string $profileFile = ''): static
    {
        $id = (string) random_int(1, 100);
        $profileFilePath = $this->staticFile->saveProfile($id, $profileFile);
        $created = ($this->diagram)($profileFilePath, $id);
        if (! $created->isCreated) {
            // @codeCoverageIgnoreStart
            throw new DiagramCreateFailedException($profileFile, $id);
            // @codeCoverageIgnoreEnd
        }

        $this->body = fopen($created->svgFile, 'rb');

        return $this;
    }
}
