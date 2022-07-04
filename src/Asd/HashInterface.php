<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

interface HashInterface
{
    public function __invoke(string $data, Algo $algo = Algo::CRC32): string;
}
