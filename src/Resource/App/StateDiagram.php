<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\ResourceObject;
use BEAR\Streamer\StreamTransferInject;
use MaAlps\MaAlps\Asd\HttpLinkFactoryInterface;
use MaAlps\MaAlps\Asd\Profile;

use function fopen;

class StateDiagram extends ResourceObject
{
    use StreamTransferInject;

    public function __construct(
        private readonly Profile $profile,
        private readonly HttpLinkFactoryInterface $linkFactory
    ) {
    }

    /**
     * @param string $profileFile ALPS raw data
     */
    public function onGet(string $profileFile = ''): static
    {
        $created = $this->profile->put($profileFile);
        $link =  (string) ($this->linkFactory)($created);
        $this->headers = [
            'Content-Type' => 'image/svg+xml',
            'Link' => $link,
        ];
        $this->body = fopen($created->svgFile, 'rb');

        return $this;
    }
}
