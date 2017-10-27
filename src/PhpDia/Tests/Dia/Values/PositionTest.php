<?php

namespace PhpDia\Tests\Dia\Values;

use PhpDia\Dia\Values\Position;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    public function testStringPosition()
    {
        $position = Position::create(1.55, 3.45);
        $this->assertEquals("1.55,3.45", $position->__toString());
    }
}