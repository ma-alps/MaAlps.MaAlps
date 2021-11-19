<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Resource\App;

use BEAR\Sunday\Extension\Application\AppInterface;
use MaAlps\MaAlps\Injector;
use PHPUnit\Framework\TestCase;

use function serialize;
use function unserialize;

final class AppTest extends TestCase
{
    public function testSerializable(): void
    {
        $app = Injector::getInstance('prod-api-app')->getInstance(AppInterface::class);
        $unserializedApp = unserialize(serialize(unserialize(serialize($app))));
        $this->assertInstanceOf(AppInterface::class, $unserializedApp);
    }

    /**
     * @covers \MaAlps\MaAlps\Module\TestModule
     */
    public function testTestModule(): void
    {
        $app = Injector::getInstance('test-api-app')->getInstance(AppInterface::class);
        $this->assertInstanceOf(AppInterface::class, $app);
    }
}
