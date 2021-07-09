<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Entity;

/** @psalm-immutable */
final class Alps
{
    public string $id;
    public bool $isPublic;
    public string $title;
    public string $userId;
    public string $asdUrl;
    public string $profileUrl;
    public string $mediaType;
}
