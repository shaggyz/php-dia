<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Geometry;
use PhpDia\Dia\Xml\Attribute;
use PhpDia\Dia\Xml\ClassElement;
use PhpDia\Dia\Xml\Operation;
use PhpDia\Dia\Xml\Parameter;
use PHPUnit\Framework\TestCase;

class GeometryTest extends TestCase
{
    /**
     * @var Geometry
     */
    protected $geometry;

    public function setUp()
    {
        parent::setUp();
        $this->geometry = Geometry::initialize();
    }

    public function testCalculateStringWidth()
    {
        $expected = Geometry::CHAR_WIDTH * 10;
        $result = $this->geometry->calculateStringWidth(str_repeat('a', 10));
        $this->assertEquals($expected, $result);
    }

    public function testCalculateAttributeWidth()
    {
        $attributeProphecy = $this->prophesize(Attribute::class);
        $attributeProphecy->getName()->willReturn('name');
        $attributeProphecy->getType()->willReturn('type');

        /** @var Attribute $attribute */
        $attribute = $attributeProphecy->reveal();

        $this->assertEquals(
            $this->geometry->calculateStringWidth('#name: type'),
            $this->geometry->calculateAttributeWidth($attribute)
        );
    }

    public function testCalculateOperationWidth()
    {
        $operationProphecy = $this->prophesize(Operation::class);
        $operationProphecy->getName()->willReturn('name');
        $operationProphecy->getType()->willReturn('type');

        $parameterProphecy = $this->prophesize(Parameter::class);
        $parameterProphecy->getName()->willReturn('pName');
        $parameterProphecy->getType()->willReturn('pType');

        /** @var Parameter $parameter */
        $parameter = $parameterProphecy->reveal();

        $operationProphecy->getParameters()->willReturn([$parameter, $parameter]);

        /** @var Operation $operation */
        $operation = $operationProphecy->reveal();

        $this->assertEquals(
            $this->geometry->calculateStringWidth('#name(pName:pType,pName:pType): type'),
            $this->geometry->calculateOperationWidth($operation)
        );
    }

    public function testCalculateElementWith()
    {
        $element = ClassElement::create('name');

        $attributeProphecy = $this->prophesize(Attribute::class);
        $attributeProphecy->getName()->willReturn('name');
        $attributeProphecy->getType()->willReturn('type');

        /** @var Attribute $attribute */
        $attribute = $attributeProphecy->reveal();

        $operationProphecy = $this->prophesize(Operation::class);
        $operationProphecy->getName()->willReturn('name');
        $operationProphecy->getType()->willReturn('type');

        $parameterProphecy = $this->prophesize(Parameter::class);
        $parameterProphecy->getName()->willReturn('pName');
        $parameterProphecy->getType()->willReturn('pType');

        /** @var Parameter $parameter */
        $parameter = $parameterProphecy->reveal();

        $operationProphecy->getParameters()->willReturn([$parameter, $parameter]);

        /** @var Operation $operation */
        $operation = $operationProphecy->reveal();

        $element->addAttribute($attribute)
            ->addOperation($operation);

        $this->assertEquals(
            $this->geometry->calculateStringWidth('#name(pName:pType,pName:pType): type'),
            $this->geometry->calculateElementWidth($element)
        );
    }


}