<?php

namespace PhpDia\Dia\Layout;

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
        $elements = $this->layer->getElements();
        $lasElementWidth = 0;

        foreach ($elements as $id => $element) {
            /** @var Element $element */
            $space = $lasElementWidth ? static::OBJECT_SPACE_WIDTH : 0;
            $this->layer->updateElement($id, $this->updateCornerX($element, $lasElementWidth + $space));
            $lasElementWidth = $element->getWidth();
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
