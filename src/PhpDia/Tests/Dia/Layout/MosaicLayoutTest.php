<?php

namespace PhpDia\Tests\Dia\Layout;

use PhpDia\Dia\Geometry;
use PhpDia\Dia\Layout\MosaicLayout;
use PhpDia\Dia\Xml\Attribute;
use PhpDia\Dia\Xml\Element;
use PhpDia\Dia\Xml\Layer;
use PHPUnit\Framework\TestCase;

class MosaicLayoutTest extends TestCase
{
    public function testMosaicLayout()
    {
        $element1 = Element::create('element1', 0)
            ->addAttribute(Attribute::create('attribute_one', 'int'));

        $attribute2 = Attribute::create('attribute_two', 'int');
        $element2 = Element::create('element2', 1)
            ->addAttribute($attribute2);

        $layer = new Layer();
        $layer->addElement($element1)
            ->addElement($element2);

        $layout = MosaicLayout::create($layer);
        $layoutLayer = $layout->layout();

        $firstElement = $layoutLayer->getElementById(0);
        $secondElement = $layoutLayer->getElementById(1);

        $this->assertEquals(0, $firstElement->getCorner()->getX());

        $geometry = Geometry::initialize();
        $expectedPadding = $geometry->calculateAttributeWidth($attribute2) + MosaicLayout::OBJECT_SPACE_WIDTH;

        $this->assertEquals($expectedPadding, $secondElement->getCorner()->getX());
    }
}
