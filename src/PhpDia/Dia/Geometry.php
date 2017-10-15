<?php

namespace PhpDia\Dia;

use PhpDia\Dia\Values\BoundingBox;
use PhpDia\Dia\Xml\Attribute;
use PhpDia\Dia\Xml\Element;
use PhpDia\Dia\Xml\Operation;

class Geometry
{
    const CHAR_WIDTH = 0.6;
    const DEFAULT_MARGIN_RIGHT = 1;
    const DEFAULT_MARGIN_BOTTOM = 1;

    /** @var BoundingBox */
    protected $margins;

    private function __construct()
    {
        $this->margins = BoundingBox::createEmpty()
            ->setRight(static::DEFAULT_MARGIN_RIGHT)
            ->setBottom(static::DEFAULT_MARGIN_BOTTOM);
    }

    /**
     * @return Geometry
     */
    public static function initialize() : Geometry
    {
        return new static();
    }

    /**
     * @param string $string
     * @return float
     */
    public function calculateStringWidth(string $string) : float
    {
        return strlen($string) * static::CHAR_WIDTH;
    }

    /**
     * @param Attribute $attribute
     * @return float
     */
    public function calculateAttributeWidth(Attribute $attribute) : float
    {

    }

    /**
     * @param Operation $operation
     * @return float
     */
    public function calculateOperationWidth(Operation $operation) : float
    {

    }

    /**
     * @param Element $element
     * @return float
     */
    public function calculateElementWidth(Element $element) : float
    {

    }
}