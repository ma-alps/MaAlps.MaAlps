<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

enum Algo
{
    case CRC32;
    case MD5;
    case sha256;
}
