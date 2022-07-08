<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

interface HttpLinkFactoryInterface
{
    public function __invoke(Created $created): AlpsLink;
}
