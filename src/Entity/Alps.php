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

    public static function factory(
        string $id,
        bool $isPublic,
        string $title,
        string $userId,
        string $asdUrl,
        string $profileUrl,
        string $mediaType,
    ): self
    {
        $alps = new self();
        $alps->id = $id;
        $alps->isPublic = $isPublic;
        $alps->title = $title;
        $alps->userId = $userId;
        $alps->asdUrl = $asdUrl;
        $alps->profileUrl = $profileUrl;
        $alps->mediaType = $mediaType;

        return $alps;
    }
}
