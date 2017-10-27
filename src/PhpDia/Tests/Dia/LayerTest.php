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

        $element2Prophecy = $this->prophesize(Element::class);
        $element2Prophecy->render()->willReturn('element');
        $element2Prophecy->getId()->willReturn(2);

        /** @var Element $element */
        $element = $elementProphecy->reveal();
        $element2 = $element2Prophecy->reveal();

        $layer = new Layer();
        $layer->addElement($element);
        $layer->addElement($element2);

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

    /**
     * @expectedException \PhpDia\Dia\Exception\ElementNotFound
     */
    public function testMissingUpdate()
    {
        $layer = new Layer();
        $layer->updateElement(99, Element::create('irrelevant', 0));
    }

    /**
     * @expectedException \PhpDia\Dia\Exception\ElementNotFound
     */
    public function testMissingElement()
    {
        $layer = new Layer();
        $layer->getElementById(9999);
    }
}