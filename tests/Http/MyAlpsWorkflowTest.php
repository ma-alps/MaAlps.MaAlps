<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Http;

//use BEAR\Dev\Http\HttpResource;
use BEAR\Dev\Http\HttpResource;
use MaAlps\MaAlps\Hypermedia\MyAlpsWorkflowTest as Workflow;

use function dirname;
use function passthru;
use function sprintf;

class MyAlpsWorkflowTest extends Workflow
{
    public static function setUpBeforeClass(): void
    {
        $setUp = sprintf('php %s', dirname(__DIR__, 2) . '/bin/setup.php');
        passthru($setUp);
    }

    protected function setUp(): void
    {
        $this->resource = new HttpResource('127.0.0.1:8080', __DIR__ . '/index.php', __DIR__ . '/log/workflow.log');
    }
}
