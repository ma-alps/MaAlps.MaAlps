<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Hypermedia;

use BEAR\AppMeta\AbstractAppMeta;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use MaAlps\MaAlps\Injector;
use PHPUnit\Framework\TestCase;

use function file_get_contents;
use function json_decode;
use function stream_get_contents;

use const JSON_THROW_ON_ERROR;

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
        $href = json_decode(json: (string) $response, flags: JSON_THROW_ON_ERROR)
            ->_links->{'doCreateStateDiagram'}
            ->href;

        $ro = $this->resource->get($href, [
            'profileFile' => file_get_contents($this->meta->appDir . '/var/mock/blog/profile.xml'),
        ]);

        $this->assertStringEqualsFile(
            $this->meta->appDir . '/var/mock/blog/profile.svg',
            stream_get_contents($ro->body)
        );

        $this->assertSame(201, $ro->code);
        $this->assertSame('image/svg+xml', $ro->headers['Content-Type']);

        return $ro;
    }
}
