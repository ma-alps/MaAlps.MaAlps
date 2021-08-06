<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\ResourceInterface;
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
    }

    public function testGet(): void
    {
        $ro = $this->resource->get('/alps-item', ['id' => '3']);

        $this->assertSame(200, $ro->code);
    }
}
