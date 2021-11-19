<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use MaAlps\MaAlps\Entity\AlpsItem as Entity;
use MaAlps\MaAlps\Query\AlpsCommandInterface;
use MaAlps\MaAlps\Query\AlpsQueryInterface;

use function assert;

class AlpsItem extends ResourceObject
{
    public function __construct(
        private AlpsQueryInterface $query,
        private AlpsCommandInterface $command,
        private ResourceInterface $resource
    ) {
    }

    /**
     * @param string $id Alps Id
     */
    #[Link(rel: 'goAlpsItemEdit', href: '/alps-item-edit{?id}')]
    public function onGet(string $id): static
    {
        $alps = $this->query->item($id);
        $this->body = (array) $alps;
        // Note: DBのカラムがそのままマッピングされてしまう
        /** @psalm-suppress UndefinedPropertyFetch */
        $this->body['_links']['doDelete'] = ['href' => "/profile?id={$alps->user_id}&alpsItemId={$alps->id}"]; // @phpstan-ignore-line

        return $this;
    }

    public function onPut(Entity $alpsItem): AlpsItem
    {
        $this->command->update(
            id: $alpsItem->id,
            isPublic: $alpsItem->isPublic,
            title: $alpsItem->title,
            asdUrl: $alpsItem->asdUrl,
            userId: $alpsItem->userId,
            profileUrl: $alpsItem->profileUrl,
            mediaType: $alpsItem->mediaType,
        );

        $ro = $this->resource->get('/alps-item', ['id' => $alpsItem->id]);
        assert($ro instanceof AlpsItem);

        return $ro;
    }
}
