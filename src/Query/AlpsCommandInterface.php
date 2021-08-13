<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Query;

use Ray\MediaQuery\Annotation\DbQuery;

interface AlpsCommandInterface
{
    #[DbQuery('alps_add')]
    public function add(
        string $id,
        bool $isPublic,
        string $title,
        string $userId,
        string $asdUrl,
        string $profileUrl,
        string $mediaType
    ): void;

    #[DbQuery('alps_update')]
    public function update(
        string $id,
        bool $isPublic,
        string $title,
        string $userId,
        string $asdUrl,
        string $profileUrl,
        string $mediaType
    ): void;

    #[DbQuery('alps_delete')]
    public function delete(string $id, string $userId): void;
}
