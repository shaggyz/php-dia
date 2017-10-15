<?php

namespace Dia;

use PhpDia\Dia\Xml\Parameter;
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testRenderParameter()
    {
        $parameter = Parameter::create('name', 'string')
            ->setValue('nico')
            ->setComment('Comment');

        $this->assertEquals(static::$expectedParameter, $parameter->render());
    }

    static $expectedParameter = <<<EOL
<dia:composite type="umlparameter">
    <dia:attribute name="name">
        <dia:string>#name#</dia:string>
    </dia:attribute>
    <dia:attribute name="type">
        <dia:string>#string#</dia:string>
    </dia:attribute>
    <dia:attribute name="value">
        <dia:string>#nico#</dia:string>
    </dia:attribute>
    <dia:attribute name="comment">
        <dia:string>#Comment#</dia:string>
    </dia:attribute>
    <dia:attribute name="kind">
        <dia:enum val="0"/>
    </dia:attribute>
</dia:composite>
EOL;

}