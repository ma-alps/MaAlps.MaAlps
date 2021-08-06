<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use MaAlps\MaAlps\Entity\AlpsItem;
use MaAlps\MaAlps\Query\AlpsCommandInterface;

class Profile extends ResourceObject
{
    public function __construct(
        private AlpsCommandInterface $command
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
}
