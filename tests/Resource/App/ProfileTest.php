<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\ResourceInterface;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use MaAlps\MaAlps\Entity\AlpsItem;
use MaAlps\MaAlps\Injector;
use PHPUnit\Framework\TestCase;

use function assert;

final class ProfileTest extends TestCase
{
    private ResourceInterface $resource;

    protected function setUp(): void
    {
        parent::setUp();
        $resource = Injector::getInstance('test-api-app')->getInstance(ResourceInterface::class);
        assert($resource instanceof ResourceInterface);
        $this->resource = $resource;
    }

    public function testPost(): void
    {
        $ro = $this->resource->post('/profile', [
            'alpsItem' => (array) AlpsItem::factory(
                id: '1',
                isPublic: false,
                title: 'The Example profile',
                userId: 'NaokiTsuchiya',
                asdUrl: 'https://ma-alps.github.io/spec/index.html',
                profileUrl: 'https://ma-alps.github.io/spec/profile.xml',
                mediaType: 'application/alps+xml',
            ),
        ]);
        $this->assertSame(201, $ro->code);
        $this->assertSame('/alps-item?id=1', $ro->headers[ResponseHeader::LOCATION]);
    }

    /** @depends testPost */
    public function testDelete(): void
    {
        $ro = $this->resource->delete('/profile', [
            'id' => 'NaokiTsuchiya',
            'alpsItemId' => '1',
        ]);

        $this->assertSame(StatusCode::OK, $ro->code);
    }
}
