<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\ResourceObject;
use BEAR\Streamer\StreamTransferInject;
use MaAlps\MaAlps\Alps\Profile;

use function fopen;

class StateDiagram extends ResourceObject
{
    use StreamTransferInject;

    /** @var array<string, string> */
    public $headers = ['Content-Type' => 'image/svg+xml'];

    public function __construct(
        private readonly Profile $profile,
    ) {
    }

    /**
     * @param string $profileFile ALPS raw data
     */
    public function onGet(string $profileFile = ''): static
    {
        $created = $this->profile->put($profileFile);
        $this->body = fopen($created->svgFile, 'rb');

        return $this;
    }
}
