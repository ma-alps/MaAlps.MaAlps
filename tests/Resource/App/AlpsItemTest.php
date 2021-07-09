<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\ResourceInterface;
use MaAlps\MaAlps\Injector;
use PHPUnit\Framework\TestCase;

use function assert;

final class AlpsItemTest extends TestCase
{
    private ResourceInterface $resource;

    protected function setUp(): void
    {
        parent::setUp();
        $resource = Injector::getInstance('api-app')->getInstance(ResourceInterface::class);
        assert($resource instanceof ResourceInterface);
        $this->resource = $resource;
    }

    public function testGet(): void
    {
        $ro = $this->resource->get('/alps-item', ['id' => '1']);

        $this->assertSame(200, $ro->code);
    }
}
