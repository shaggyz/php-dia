<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Xml\Attribute;
use PhpDia\Dia\Xml\Operation;
use PhpDia\Dia\Xml\Parameter;
use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
{
    public function testRenderOperation()
    {
        $parameterProphecy = $this->prophesize(Parameter::class);
        $parameterProphecy->render()->willReturn('parameter');

        /** @var Parameter $parameter */
        $parameter = $parameterProphecy->reveal();

        $operation = Operation::create('setPublic', 'string')
            ->addParameter($parameter)
            ->addParameter($parameter)
            ->setVisibility(Attribute::VISIBILITY_PRIVATE)
            ->setComment('Comment Test')
            ->setAbstract(true)
            ->setQuery(true)
            ->setClassScope(true);

        $expected = file_get_contents(__DIR__ . '/stubs/operation.stub.xml');
        $this->assertEquals($expected, $operation->render());
    }
}
