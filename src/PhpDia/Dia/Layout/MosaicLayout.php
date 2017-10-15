<?php

namespace PhpDia\Dia\Layout;

use PhpDia\Dia\Xml\Layer;

class MosaicLayout extends BaseLayout implements Layout
{
    /**
     * @return Layer
     */
    protected function layoutElements() : Layer
    {


        return $this->layout();
    }

    /**
     * @return Layer
     */
    public function layout(): Layer
    {
        return $this->layoutElements();
    }
}