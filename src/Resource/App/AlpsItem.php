<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\ResourceObject;
use MaAlps\MaAlps\Query\AlpsQueryInterface;

class AlpsItem extends ResourceObject
{
    public function __construct(
        private AlpsQueryInterface $query
    ){}

    /**
     * @param string $id Alps Id
     */
    public function onGet(string $id): static
    {
        $this->body = (array) $this->query->item($id);

        return $this;
    }
}
