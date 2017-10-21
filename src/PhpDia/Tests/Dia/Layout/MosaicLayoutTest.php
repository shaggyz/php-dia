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
        $element1 = Element::create('element1', 0)->setWidth(10);
        $element2 = Element::create('element2', 1)->setWidth(20);

        $layer = new Layer();
        $layer->addElement($element1)
            ->addElement($element2);

        $layout = MosaicLayout::create($layer);
        $layoutLayer = $layout->layout();

        $firstElement = $layoutLayer->getElementById(0);
        $secondElement = $layoutLayer->getElementById(1);

        $this->assertEquals(0, $firstElement->getCorner()->getX());
        $this->assertEquals(11, $secondElement->getCorner()->getX());
    }
}
