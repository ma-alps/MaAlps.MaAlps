<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Alps;

interface DiagramInterface
{
    public function __invoke(string $profile, string $id): Created;
}
