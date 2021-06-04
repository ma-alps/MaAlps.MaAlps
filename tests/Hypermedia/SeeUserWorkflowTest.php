<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Hypermedia;

use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use MaAlps\MaAlps\Injector;
use PHPUnit\Framework\TestCase;

use function json_decode;

/**
 * Identify users from ALPS items
 *
 *　ALPSアイテムからユーザーを確認
 */
class SeeUserWorkflowTest extends TestCase
{
    protected ResourceInterface $resource;

    protected function setUp(): void
    {
        $injector = Injector::getInstance('api-app');
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
    public function testGoAlpsItem(ResourceObject $response): ResourceObject
    {
        $json = (string) $response;
        $href = json_decode($json)->_links->{'goAlpsItem'}->href;
        $ro = $this->resource->get($href, []);
        $this->assertSame(200, $ro->code);

        return $ro;
    }

    /**
     * @depends testGoAlpsItem
     */
    public function testGoUser(ResourceObject $response): ResourceObject
    {
        $json = (string) $response;
        $href = json_decode($json)->_links->{'goUser'}->href;
        $ro = $this->resource->get($href);
        $this->assertSame(200, $ro->code);

        return $ro;
    }
}
