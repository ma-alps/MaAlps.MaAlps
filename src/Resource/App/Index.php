<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    #[Link(rel: 'goProfile', href: '/profile{?id}')]
    #[JsonSchema(schema: 'index.json')]
    public function onGet(): static
    {
        // TODO: あとで実装する
        $this->body['alpsList'] = [];

        return $this;
    }
}
