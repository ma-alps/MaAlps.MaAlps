<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Hypermedia;

use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use MaAlps\MaAlps\Injector;
use PHPUnit\Framework\TestCase;

use function json_decode;

/**
 * Create diagram directly
 *
 * ダイアグラムを直接生成
 */
class CreateAsdWorkflowTest extends TestCase
{
    protected ResourceInterface $resource;

    protected function setUp(): void
    {
        $injector = Injector::getInstance('test-api-app');
        $this->resource = $injector->getInstance(ResourceInterface::class);
    }

    public function testIndex(): ResourceObject
    {
        $index = $this->resource->get('/index');
        $this->assertSame(200, $index->code);

        return $index;
    }

    /**
     * @depends testIndex
     */
    public function testDoCreateStateDiagram(ResourceObject $response): ResourceObject
    {
        $json = (string) $response;
        $href = json_decode($json)->_links->{'doCreateStateDiagram'}->href;
        $ro = $this->resource->get($href);
        $this->assertSame(201, $ro->code);

        return $ro;
    }
}
