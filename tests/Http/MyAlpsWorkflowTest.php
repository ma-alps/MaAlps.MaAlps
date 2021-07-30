<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Http;

//use BEAR\Dev\Http\HttpResource;
use MaAlps\MaAlps\Hypermedia\MyAlpsWorkflowTest as Workflow;

class MyAlpsWorkflowTest extends Workflow
{
    protected function setUp(): void
    {
        $this->markTestSkipped();
//        $this->resource = new HttpResource('127.0.0.1:8080', __DIR__ . '/index.php', __DIR__ . '/log/workflow.log');
    }
}
