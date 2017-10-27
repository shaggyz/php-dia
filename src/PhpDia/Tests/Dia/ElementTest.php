<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Xml\Attribute;
use PhpDia\Dia\Xml\ClassElement;
use PhpDia\Dia\Xml\Operation;
use PhpDia\Dia\Values\BoundingBox;
use PhpDia\Dia\Values\Position;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{
    public function testRenderElement()
    {
        $attributeProphecy = $this->prophesize(Attribute::class);
        $attributeProphecy->render()->willReturn('attribute');

        $operationProphecy = $this->prophesize(Operation::class);
        $operationProphecy->render()->willReturn('operation');

        $element = ClassElement::create('ClassNico', 1)
            ->setPosition(Position::create(1.55, 3.45))
            ->setCorner(Position::create(1.55, 3.45))
            ->setBoundingBox(BoundingBox::create(1.5, 3.4, 14.805, 9.3))
            ->setComment('Class comment')
            ->addAttribute($attributeProphecy->reveal())
            ->addAttribute($attributeProphecy->reveal())
            ->addOperation($operationProphecy->reveal())
            ->addOperation($operationProphecy->reveal())
            ->setWidth(13.205)
            ->setHeight(5.7999999999999);

        $expected = file_get_contents(__DIR__ . '/stubs/element.stub.xml');
        $this->assertEquals($expected, $element->render());
        $this->assertEquals(1, $element->getId());
    }
}
