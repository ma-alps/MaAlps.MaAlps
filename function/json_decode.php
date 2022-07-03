<?php

declare(strict_types=1);

namespace MaAlps\MaAlps;

use const JSON_THROW_ON_ERROR;

function json_decode(string $json)
{
    return \json_decode($json, false, 512, JSON_THROW_ON_ERROR);
}
