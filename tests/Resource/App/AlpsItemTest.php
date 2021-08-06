<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\ResourceInterface;
use Koriym\HttpConstants\StatusCode;
use MaAlps\MaAlps\Entity\AlpsItem;
use MaAlps\MaAlps\Injector;
use PHPUnit\Framework\TestCase;

use function assert;

final class AlpsItemTest extends TestCase
{
    private ResourceInterface $resource;

    protected function setUp(): void
    {
        parent::setUp();
        $resource = Injector::getInstance('test-api-app')->getInstance(ResourceInterface::class);
        assert($resource instanceof ResourceInterface);
        $this->resource = $resource;
    }

    public function testGet(): void
    {
        $this->resource->post('/profile', [
            'alpsItem' => (array) AlpsItem::factory(
                id: '3',
                isPublic: false,
                title: 'The Example profile',
                userId: 'NaokiTsuchiya',
                asdUrl: 'https://ma-alps.github.io/spec/index.html',
                profileUrl: 'https://ma-alps.github.io/spec/profile.xml',
                mediaType: 'application/alps+xml',
            ),
        ]);
        $ro = $this->resource->get('/alps-item', ['id' => '3']);

        $this->assertSame(200, $ro->code);
    }

    /** @depends testGet */
    public function testPut(): void
    {
        $ro = $this->resource->put('/alps-item', [
            'alpsItem' => (array) AlpsItem::factory(
                id: '3',
                isPublic: true,
                title: 'updated',
                userId: 'NaokiTsuchiya',
                asdUrl: 'https://ma-alps.github.io/spec/index.html',
                profileUrl: 'https://ma-alps.github.io/spec/profile.xml',
                mediaType: 'application/alps+json',
            ),
        ]);
        unset($ro->body['_links']);

        $this->assertSame(StatusCode::OK, $ro->code);
        $this->assertSame(
            [
                'id' => '3',
                'title' => 'updated',
                'is_public' => '1',
                'user_id' => 'NaokiTsuchiya',
                'asd_url' => 'https://ma-alps.github.io/spec/index.html',
                'profile_url' => 'https://ma-alps.github.io/spec/profile.xml',
                'media_type' => 'application/alps+json',
            ],
            $ro->body
        );
    }
}
