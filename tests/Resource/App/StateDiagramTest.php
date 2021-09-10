<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Resource\ResourceInterface;
use MaAlps\MaAlps\Injector;
use PHPUnit\Framework\TestCase;

use function assert;

final class StateDiagramTest extends TestCase
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
        $this->markTestIncomplete(); // @phpstan-ignore-next-line
    }
}
