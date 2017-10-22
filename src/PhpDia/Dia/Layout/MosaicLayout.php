<?php

namespace PhpDia\Dia\Layout;

use PhpDia\Dia\Geometry;
use PhpDia\Dia\Xml\Element;
use PhpDia\Dia\Xml\Layer;

class MosaicLayout extends BaseLayout implements Layout
{
    const LAYOUT_TYPE = 0;

    /**
     * @return Layer
     */
    protected function layoutElements() : Layer
    {
        $lastElementWidth = 0;

        foreach ($this->layer->getElements() as $id => $element) {
            /** @var Element $element */
            $space = $lastElementWidth ? static::OBJECT_SPACE_WIDTH : 0;
            $this->layer->updateElement($id, $this->updateCornerX($element, $lastElementWidth + $space));
            $lastElementWidth = $element->getWidth();
        }

        return $this->layer;
    }

    /**
     * @param Element $element
     * @param float $cornerX
     * @return Element
     */
    protected function updateCornerX(Element $element, float $cornerX) : Element
    {
        $element->setWidth(Geometry::initialize()->calculateElementWidth($element));
        $corner = $element->getCorner();
        $corner->setX($cornerX);
        $element->setCorner($corner);
        return $element;
    }

    /**
     * @return Layer
     */
    public function layout() : Layer
    {
        return $this->layoutElements();
    }
}
