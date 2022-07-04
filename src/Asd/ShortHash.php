<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

use function base64_encode;
use function hash;
use function pack;
use function rtrim;
use function strtr;

final class ShortHash implements HashInterface
{
    public function __invoke(string $data, Algo $algo = Algo::CRC32): string
    {
        return strtr(rtrim(base64_encode(pack('H*', hash($algo->name, $data))), '='), '+/', '-_');
    }
}
