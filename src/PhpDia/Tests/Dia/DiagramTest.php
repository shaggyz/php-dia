<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Diagram;
use PHPUnit\Framework\TestCase;

class DiagramTest extends TestCase
{
    public function testRenderDiagram()
    {
        $diagram = new Diagram();

        $diagram->setBackground('#666000')
            ->setPageBreakColor('#000666')
            ->setPaperName('Letter')
            ->setPortrait(false)
            ->setFitTo(true)
            ->setScaling(2);

        $this->assertEquals($this->getExpected(), $diagram->render());
    }

    public function getExpected()
    {
        static $expected = <<<EOL
<dia:diagramdata>
    <dia:attribute name="background">
        <dia:color val="#666000"/>
    </dia:attribute>
    <dia:attribute name="pagebreak">
        <dia:color val="#000666"/>
    </dia:attribute>
    <dia:attribute name="paper">
        <dia:composite type="paper">
            <dia:attribute name="name">
                <dia:string>#Letter#</dia:string>
            </dia:attribute>
            <dia:attribute name="tmargin">
                <dia:real val="2.8222000598907471"/>
            </dia:attribute>
            <dia:attribute name="bmargin">
                <dia:real val="2.8222000598907471"/>
            </dia:attribute>
            <dia:attribute name="lmargin">
                <dia:real val="2.8222000598907471"/>
            </dia:attribute>
            <dia:attribute name="rmargin">
                <dia:real val="2.8222000598907471"/>
            </dia:attribute>
            <dia:attribute name="is_portrait">
                <dia:boolean val="false"/>
            </dia:attribute>
            <dia:attribute name="scaling">
                <dia:real val="2"/>
            </dia:attribute>
            <dia:attribute name="fitto">
                <dia:boolean val="true"/>
            </dia:attribute>
        </dia:composite>
    </dia:attribute>
    <dia:attribute name="grid">
        <dia:composite type="grid">
            <dia:attribute name="width_x">
                <dia:real val="1"/>
            </dia:attribute>
            <dia:attribute name="width_y">
                <dia:real val="1"/>
            </dia:attribute>
            <dia:attribute name="visible_x">
                <dia:int val="1"/>
            </dia:attribute>
            <dia:attribute name="visible_y">
                <dia:int val="1"/>
            </dia:attribute>
            <dia:composite type="color"/>
        </dia:composite>
    </dia:attribute>
    <dia:attribute name="color">
        <dia:color val="#d8e5e5"/>
    </dia:attribute>
    <dia:attribute name="guides">
        <dia:composite type="guides">
            <dia:attribute name="hguides"/>
            <dia:attribute name="vguides"/>
        </dia:composite>
    </dia:attribute>
</dia:diagramdata>
EOL;
        return $expected;
    }
}