<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Asd;

use PHPUnit\Framework\TestCase;

class AlpsLinkFactoryTest extends TestCase
{
    public function testNewInstance(): void
    {
        $factory = new HttpLinkFactory('/var/www/alps');
        $alpsLink = $factory->__invoke(Created::fromProfile('/var/www/alps/aaa/profile.xml'));
        $alpsLinkString = (string) $alpsLink;
        $this->assertSame('<http://localhost:8080/aaa/profile.xml>; rel="alps_profile", <http://localhost:8080/aaa/profile.xml.dot>; rel="alps_dot", <http://localhost:8080/aaa/profile.xml.svg>; rel="alps_svg"', $alpsLinkString);
    }
}
