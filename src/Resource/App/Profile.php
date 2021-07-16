<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use MaAlps\MaAlps\Entity\Alps;
use MaAlps\MaAlps\Query\AlpsCommandInterface;

class Profile extends ResourceObject
{
    public function __construct(
        private AlpsCommandInterface $command
    ) {}

    #[Link(rel: 'doCreate', href: '/profile')]
    public function onGet(string $id)
    {
        return $this;
    }

    #[JsonSchema(params: 'doCreate.json')]
    public function onPost(Alps $alps): static
    {
        $this->command->add(
            id: $alps->id,
            isPublic: $alps->isPublic,
            title: $alps->title,
            userId: $alps->userId,
            asdUrl: $alps->asdUrl,
            profileUrl: $alps->profileUrl,
            mediaType: $alps->mediaType,
        );
        $this->code = StatusCode::CREATED;
        $this->headers[ResponseHeader::LOCATION] = '/alps-item?id=' . $alps->id;

        return $this;
    }
}
