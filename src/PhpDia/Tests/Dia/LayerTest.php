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
        $elementProphecy->getId()->willReturn(1);

        /** @var Element $element */
        $element = $elementProphecy->reveal();

        $layer = new Layer();
        $layer->addElement($element);
        $layer->addElement($element);

        $expected = <<<EOL
<dia:layer name="Background" visible="true" active="true">
    element
    element
</dia:layer>
EOL;

        $this->assertEquals($expected, $layer->render());
        $this->assertEquals($element, $layer->getElementById(1));
    }

    public function testUpdateElement()
    {
        $element = Element::create('element', 1);

        $layer = new Layer();
        $layer->addElement($element);

        $element->setName('updatedElement');

        $layer->updateElement(1, $element);

        $this->assertEquals('updatedElement', $layer->getElementById(1)->getName());
    }
}