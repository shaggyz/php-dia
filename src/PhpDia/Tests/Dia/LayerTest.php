<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Xml\Element;
use PhpDia\Dia\Xml\Layer;
use PHPUnit\Framework\TestCase;

class LayerTest extends TestCase
{
    public function testRenderLayer()
    {
        $elementProphecy = $this->prophesize(Element::class);
        $elementProphecy->render()->willReturn('element');

        $layer = new Layer();
        $layer->addElement($elementProphecy->reveal());
        $layer->addElement($elementProphecy->reveal());

        $expected = <<<EOL
<dia:layer name="Background" visible="true" active="true">
    element
    element
</dia:layer>
EOL;

        $this->assertEquals($expected, $layer->render());
    }
}