<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{

    public function onGet(): static
    {
        $this->body['_links'] = [
            'goProfile' => [
                'href' => '/profile?id=my',
            ]
        ];

        return $this;
    }
}
