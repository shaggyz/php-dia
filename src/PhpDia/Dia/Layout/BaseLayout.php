<?php

namespace PhpDia\Dia\Layout;

use PhpDia\Dia\Xml\Layer;

abstract class BaseLayout implements Layout
{
    /** @var Layer */
    protected $layer;

    /**
     * @param Layer $layer
     */
    private function __construct(Layer $layer)
    {
        $this->layer = $layer;
    }

    /**
     * @param Layer $layer
     * @return Layout
     */
    public static function create(Layer $layer): Layout
    {
        return new static($layer);
    }
}