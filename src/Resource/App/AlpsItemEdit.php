<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;
use MaAlps\MaAlps\Query\AlpsQueryInterface;

/**
 * @codeCoverageIgnore
 */
class AlpsItemEdit extends ResourceObject
{
    public function __construct(
        private readonly AlpsQueryInterface $query
    ) {
    }

    #[Link(rel: 'doEdit', href: '/alps-item{?id}')]
    public function onGet(string $id): static
    {
        $this->body = ['alpsItem' => $this->query->item($id)];

        return $this;
    }
}
