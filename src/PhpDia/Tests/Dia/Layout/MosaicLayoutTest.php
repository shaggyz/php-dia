<?php

namespace PhpDia\Tests\Dia\Layout;

use PhpDia\Dia\Layout\MosaicLayout;
use PhpDia\Dia\Xml\Element;
use PhpDia\Dia\Xml\Layer;
use PHPUnit\Framework\TestCase;

class MosaicLayoutTest extends TestCase
{
    public function testMosaicLayout()
    {
        $elementProphecy1 = $this->prophesize(Element::class);
        $elementProphecy1->getId()->willReturn(0);
        $elementProphecy1->getWith()->willReturn(10);

        $elementProphecy2 = $this->prophesize(Element::class);
        $elementProphecy1->getId()->willReturn(1);
        $elementProphecy2->getWith()->willReturn(20);

        $layerProphecy = $this->prophesize(Layer::class);
        $layerProphecy->getElementByid(0)->willReturn($elementProphecy1->reveal());
        $layerProphecy->getElementByid(1)->willReturn($elementProphecy2->reveal());

        /** @var Layer $layer */
        $layer = $layerProphecy->reveal();

        $layout = MosaicLayout::create($layer);
        $layoutLayer = $layout->layout();

        $firstElement = $layoutLayer->getElementById(0);
        $secondElement = $layoutLayer->getElementById(1);

        $this->assertEquals(0, $firstElement->getCorner()->getX());
        $this->assertEquals(11, $secondElement->getCorner()->getX());
    }
}