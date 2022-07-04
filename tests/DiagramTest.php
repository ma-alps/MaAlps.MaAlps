<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Alps;

use PHPUnit\Framework\TestCase;

use function dirname;
use function sprintf;
use function unlink;

class DiagramTest extends TestCase
{
    public function testDiagram(): void
    {
        $dir = __DIR__ . '/tmp';
        $dotFile = sprintf('%s/alps.1.svg', $dir);
        @unlink($dotFile);
        $profile = dirname(__DIR__) . '/var/mock/blog/profile.xml';
        $created = (new Diagram())->draw($profile);
        $this->assertFileExists($created->svgFile);
        $this->assertFileExists($created->dotFile);
        $this->assertFileExists($created->profileFile);
    }
}
