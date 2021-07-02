<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Query;

use MaAlps\MaAlps\Entity\Alps;
use Ray\MediaQuery\Annotation\DbQuery;

interface AlpsQueryInterface
{
    #[DbQuery('alps_item')]
    public function item(string $id): Alps;

    /**
     * @return array<Alps>
     */
    #[DbQuery('alps_list')]
    public function list(): array;
}
