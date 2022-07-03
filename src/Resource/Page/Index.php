<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\Page;

use BEAR\Resource\ResourceObject;

/**
 * @codeCoverageIgnore
 */
class Index extends ResourceObject
{
    /** @var array{greeting: string} */
    public $body;

    public function onGet(string $name = 'BEAR.Sunday'): static
    {
        $this->body = [
            'greeting' => 'Hello ' . $name,
        ];

        return $this;
    }
}
