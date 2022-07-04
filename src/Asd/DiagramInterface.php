<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

interface DiagramInterface
{
    public function draw(string $profileFilePath): Created;
}
