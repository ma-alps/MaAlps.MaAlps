<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use MaAlps\MaAlps\Entity\AlpsItem;
use MaAlps\MaAlps\Query\AlpsCommandInterface;

use function assert;

class Profile extends ResourceObject
{
    public function __construct(
        private AlpsCommandInterface $command,
        private ResourceInterface $resource
    ) {
    }

    #[Link(rel: 'doCreate', href: '/profile')]
    public function onGet(string $id): static
    {
        return $this;
    }

    #[JsonSchema(params: 'doCreate.json')]
    public function onPost(AlpsItem $alpsItem): static
    {
        $this->command->add(
            id: $alpsItem->id,
            isPublic: $alpsItem->isPublic,
            title: $alpsItem->title,
            userId: $alpsItem->userId,
            asdUrl: $alpsItem->asdUrl,
            profileUrl: $alpsItem->profileUrl,
            mediaType: $alpsItem->mediaType,
        );
        $this->code = StatusCode::CREATED;
        $this->headers[ResponseHeader::LOCATION] = '/alps-item?id=' . $alpsItem->id;

        return $this;
    }

    public function onDelete(string $id, string $alpsItemId): Profile
    {
        $this->command->delete(
            id: $alpsItemId,
            userId: $id,
        );

        $ro = $this->resource->get('/profile', ['id' => $id]);
        assert($ro instanceof Profile);

        return $ro;
    }
}
