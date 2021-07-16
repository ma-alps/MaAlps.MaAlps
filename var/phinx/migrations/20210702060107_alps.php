<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Alps extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('alps', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'uuid')
            ->addColumn('is_public', 'boolean')
            ->addColumn('title', 'string')
            ->addColumn('user_id', 'string')
            ->addColumn('asd_url', 'string')
            ->addColumn('profile_url', 'string')
            ->addColumn('media_type', 'string')
            ->addIndex('id', ['unique' => true])
            ->create();
    }
}
