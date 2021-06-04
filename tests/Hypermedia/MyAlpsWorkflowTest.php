<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Hypermedia;

use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use MaAlps\MaAlps\Injector;
use PHPUnit\Framework\TestCase;

use function json_decode;

/**
 * Create, edit, and delete Alps profile
 *
 * アルプスプロファイルの生成、編集、削除
 */
class MyAlpsWorkflowTest extends TestCase
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
    public function testGoMyAlps(ResourceObject $response): ResourceObject
    {
        $json = (string) $response;
        $href = json_decode($json)->_links->{'goMyAlps'}->href;
        $ro = $this->resource->get($href);
        $this->assertSame(200, $ro->code);

        return $ro;
    }

    /**
     * @depends testGoMyAlps
     */
    public function testDoCreate(ResourceObject $response): ResourceObject
    {
        $json = (string) $response;
        $href = json_decode($json)->_links->{'doCreate'}->href;
        $ro = $this->resource->post($href, []);
        $this->assertSame(201, $ro->code);

        return $ro;
    }

    /**
     * @depends testDoCreate
     */
    public function testCreatedAlpsItem(ResourceObject $response): ResourceObject
    {
        $href = $response->headers[ResponseHeader::LOCATION];
        $ro = $this->resource->get($href);
        $this->assertSame(StatusCode::CREATED, $ro->code);

        return $ro;
    }

    /**
     * @depends testCreatedAlpsItem
     */
    public function testGoAlpsItemEdit(ResourceObject $response): ResourceObject
    {
        $json = (string) $response;
        $href = json_decode($json)->_links->{'goAlpsItemEdit'}->href;
        $ro = $this->resource->get($href);
        $this->assertSame(200, $ro->code);

        return $ro;
    }

    /**
     * @depends testGoAlpsItemEdit
     */
    public function testDoEdit(ResourceObject $response): ResourceObject
    {
        $json = (string) $response;
        $href = json_decode($json)->_links->{'doEdit'}->href;
        $ro = $this->resource->put($href, []);
        $this->assertSame(StatusCode::NO_CONTENT, $ro->code);

        return $ro;
    }

    /**
     * @depends testDoEdit
     */
    public function testDoDelete(ResourceObject $response): ResourceObject
    {
        $json = (string) $response;
        $href = json_decode($json)->_links->{'doDelete'}->href;
        $ro = $this->resource->put($href);
        $this->assertSame(StatusCode::NO_CONTENT, $ro->code);

        return $ro;
    }
}
