<?php

namespace PhpDia\Tests\Dia\Values;

use PhpDia\Dia\Values\BoundingBox;
use PHPUnit\Framework\TestCase;

class BoundingBoxTest extends TestCase
{
    public function testBoundingBoxString()
    {
        $boundingBox = BoundingBox::create(
            1.5,
            3.4,
            14.805,
            9.3
        );

        $this->assertEquals("1.5,3.4;14.805,9.3", $boundingBox->__toString());
    }
}