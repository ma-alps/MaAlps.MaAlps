<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    #[Link(rel: 'goProfile', href: '/profile{?id}')]
    #[Link(rel: 'doCreateStateDiagram', href: '/stateDiagram{?profileFile}')]
    public function onGet(): static
    {
        return $this;
    }
}
