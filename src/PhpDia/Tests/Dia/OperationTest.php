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

        $this->assertEquals(static::$expectedOperation, $operation->render());
    }

    static $expectedOperation = <<<EOL
<dia:composite type="umloperation">
    <dia:attribute name="name">
        <dia:string>#setPublic#</dia:string>
    </dia:attribute>
    <dia:attribute name="stereotype">
        <dia:string>##</dia:string>
    </dia:attribute>
    <dia:attribute name="type">
        <dia:string>#string#</dia:string>
    </dia:attribute>
    <dia:attribute name="visibility">
        <dia:enum val="1"/>
    </dia:attribute>
    <dia:attribute name="comment">
        <dia:string>#Comment Test#</dia:string>
    </dia:attribute>
    <dia:attribute name="abstract">
        <dia:boolean val="true"/>
    </dia:attribute>
    <dia:attribute name="inheritance_type">
        <dia:enum val="2"/>
    </dia:attribute>
    <dia:attribute name="query">
        <dia:boolean val="true"/>
    </dia:attribute>
    <dia:attribute name="class_scope">
        <dia:boolean val="true"/>
    </dia:attribute>
    <dia:attribute name="parameters">
                parameter
                parameter
            </dia:attribute>
</dia:composite>
EOL;

}