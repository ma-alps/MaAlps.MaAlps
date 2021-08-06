<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Query;

use MaAlps\MaAlps\Entity\AlpsItem;
use Ray\MediaQuery\Annotation\DbQuery;

interface AlpsQueryInterface
{
    #[DbQuery('alps_item', entity: AlpsItem::class)]
    public function item(string $id): AlpsItem;

    /**
     * @return array<AlpsItem>
     */
    #[DbQuery('alps_list')]
    public function list(): array;
}
