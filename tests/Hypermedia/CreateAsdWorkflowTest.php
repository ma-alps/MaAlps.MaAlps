<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Hypermedia;

use BEAR\AppMeta\AbstractAppMeta;
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
    private AbstractAppMeta $meta;

    protected function setUp(): void
    {
        $injector = Injector::getInstance('test-hal-api-app');
        $this->resource = $injector->getInstance(ResourceInterface::class);
        $this->meta = $injector->getInstance(AbstractAppMeta::class);
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
        $href = json_decode(json: (string)$response, flags: JSON_THROW_ON_ERROR)
            ->_links->{'doCreateStateDiagram'}
            ->href;

        $ro = $this->resource->get($href, [
            'profileFile' => file_get_contents($this->meta->appDir . '/var/mock/blog/profile.xml')
        ]);

        $this->assertFileEquals(
            $this->meta->appDir . '/var/mock/blog/profile.svg',
            $ro->headers['Content-Location'],
            'Content-Location: '. $ro->headers['Content-Location']
        );

        $this->assertSame(201, $ro->code);
        return $ro;
    }
}
