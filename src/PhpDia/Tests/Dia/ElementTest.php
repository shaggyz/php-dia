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

        $element = ClassElement::create('ClassNico')
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

        $this->assertEquals($this->getExpected(), $element->render());
    }

    public function getExpected() : string
    {
        static $expected = <<<EOL
<dia:object type="UML - Class" version="0" id="O0">
    <dia:attribute name="obj_pos">
        <dia:point val="1.55,3.45"/>
    </dia:attribute>
    <dia:attribute name="obj_bb">
        <dia:rectangle val="1.5,3.4;14.805,9.3"/>
    </dia:attribute>
    <dia:attribute name="elem_corner">
        <dia:point val="1.55,3.45"/>
    </dia:attribute>
    <dia:attribute name="elem_width">
        <dia:real val="13.205"/>
    </dia:attribute>
    <dia:attribute name="elem_height">
        <dia:real val="5.7999999999999"/>
    </dia:attribute>
    <dia:attribute name="name">
        <dia:string>#ClassNico#</dia:string>
    </dia:attribute>
    <dia:attribute name="stereotype">
        <dia:string>##</dia:string>
    </dia:attribute>
    <dia:attribute name="comment">
        <dia:string>#Class comment#</dia:string>
    </dia:attribute>
    <dia:attribute name="abstract">
        <dia:boolean val="false"/>
    </dia:attribute>
    <dia:attribute name="suppress_attributes">
        <dia:boolean val="false"/>
    </dia:attribute>
    <dia:attribute name="suppress_operations">
        <dia:boolean val="false"/>
    </dia:attribute>
    <dia:attribute name="visible_attributes">
        <dia:boolean val="true"/>
    </dia:attribute>
    <dia:attribute name="visible_operations">
        <dia:boolean val="true"/>
    </dia:attribute>
    <dia:attribute name="visible_comments">
        <dia:boolean val="false"/>
    </dia:attribute>
    <dia:attribute name="wrap_operations">
        <dia:boolean val="true"/>
    </dia:attribute>
    <dia:attribute name="wrap_after_char">
        <dia:int val="40"/>
    </dia:attribute>
    <dia:attribute name="comment_line_length">
        <dia:int val="17"/>
    </dia:attribute>
    <dia:attribute name="comment_tagging">
        <dia:boolean val="false"/>
    </dia:attribute>
    <dia:attribute name="line_width">
        <dia:real val="0.10000000000000001"/>
    </dia:attribute>
    <dia:attribute name="line_color">
        <dia:color val="#000000"/>
    </dia:attribute>
    <dia:attribute name="fill_color">
        <dia:color val="#ffffff"/>
    </dia:attribute>
    <dia:attribute name="text_color">
        <dia:color val="#000000"/>
    </dia:attribute>
    <dia:attribute name="normal_font">
        <dia:font family="monospace" style="0" name="Courier"/>
    </dia:attribute>
    <dia:attribute name="abstract_font">
        <dia:font family="monospace" style="88" name="Courier-BoldOblique"/>
    </dia:attribute>
    <dia:attribute name="polymorphic_font">
        <dia:font family="monospace" style="8" name="Courier-Oblique"/>
    </dia:attribute>
    <dia:attribute name="classname_font">
        <dia:font family="sans" style="80" name="Helvetica-Bold"/>
    </dia:attribute>
    <dia:attribute name="abstract_classname_font">
        <dia:font family="sans" style="88" name="Helvetica-BoldOblique"/>
    </dia:attribute>
    <dia:attribute name="comment_font">
        <dia:font family="sans" style="8" name="Helvetica-Oblique"/>
    </dia:attribute>
    <dia:attribute name="normal_font_height">
        <dia:real val="0.80000000000000004"/>
    </dia:attribute>
    <dia:attribute name="polymorphic_font_height">
        <dia:real val="0.80000000000000004"/>
    </dia:attribute>
    <dia:attribute name="abstract_font_height">
        <dia:real val="0.80000000000000004"/>
    </dia:attribute>
    <dia:attribute name="classname_font_height">
        <dia:real val="1"/>
    </dia:attribute>
    <dia:attribute name="abstract_classname_font_height">
        <dia:real val="1"/>
    </dia:attribute>
    <dia:attribute name="comment_font_height">
        <dia:real val="0.69999999999999996"/>
    </dia:attribute>
    <dia:attribute name="attributes">
        attribute
        attribute
        </dia:attribute>
    <dia:attribute name="operations">
        operation
        operation
        </dia:attribute>
    <dia:attribute name="template">
        <dia:boolean val="false"/>
    </dia:attribute>
    <dia:attribute name="templates"/>
</dia:object>
EOL;
        return $expected;
    }
}