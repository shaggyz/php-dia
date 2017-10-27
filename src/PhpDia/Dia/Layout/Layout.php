<?php

namespace PhpDia\Dia\Layout;

use PhpDia\Dia\Xml\Layer;

interface Layout
{
    /**
     * @param Layer $layer
     * @return Layout
     */
    public static function create(Layer $layer) : Layout;

    /**
     * @return Layer
     */
    public function layout() : Layer;
}