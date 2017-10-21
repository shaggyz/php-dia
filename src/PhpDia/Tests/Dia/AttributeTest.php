<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Xml\Attribute;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{
    public function testRenderAttribute()
    {
        $attribute = Attribute::create('publicVar', 'int')
            ->setValue(5)
            ->setComment('Public int')
            ->setVisibility(Attribute::VISIBILITY_PUBLIC)
            ->setAbstract(true)
            ->setClassScope(true);

        $this->assertEquals(static::$expectedPublic, $attribute->render());
    }

    private static $expectedPublic = <<<EOL
<dia:composite type="umlattribute">
    <dia:attribute name="name">
        <dia:string>#publicVar#</dia:string>
    </dia:attribute>
    <dia:attribute name="type">
        <dia:string>#int#</dia:string>
    </dia:attribute>
    <dia:attribute name="value">
        <dia:string>#5#</dia:string>
    </dia:attribute>
    <dia:attribute name="comment">
        <dia:string>#Public int#</dia:string>
    </dia:attribute>
    <dia:attribute name="visibility">
        <dia:enum val="0"/>
    </dia:attribute>
    <dia:attribute name="abstract">
        <dia:boolean val="true"/>
    </dia:attribute>
    <dia:attribute name="class_scope">
        <dia:boolean val="true"/>
    </dia:attribute>
</dia:composite>
EOL;
}
