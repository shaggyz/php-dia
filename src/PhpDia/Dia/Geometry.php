<?php

namespace PhpDia\Dia;

use PhpDia\Dia\Values\BoundingBox;
use PhpDia\Dia\Xml\Attribute;
use PhpDia\Dia\Xml\Element;
use PhpDia\Dia\Xml\Operation;
use PhpDia\Dia\Xml\Parameter;

class Geometry
{
    const CHAR_WIDTH = 0.4;
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
        return $this->calculateStringWidth(
            sprintf(
                "#%s: %s",
                $attribute->getName(),
                $attribute->getType()
            )
        );
    }

    /**
     * @param Operation $operation
     * @return float
     */
    public function calculateOperationWidth(Operation $operation) : float
    {
        $parameters = [];

        if ($operation->hasParameters()) {
            foreach ($operation->getParameters() as $parameter) {
                $parameters[] = $this->getParameterString($parameter);
            }
        }

        return $this->calculateStringWidth(
            sprintf(
                "#%s(%s): %s",
                $operation->getName(),
                implode(',', $parameters),
                $operation->getType()
            )
        );
    }

    /**
     * @param Element $element
     * @return float
     */
    public function calculateElementWidth(Element $element) : float
    {
        $width = 0;

        foreach ($element->getAttributes() as $attribute) {
            $attributeWidth = $this->calculateAttributeWidth($attribute);
            $width = $attributeWidth > $width ? $attributeWidth : $width;
        }

        foreach ($element->getOperations() as $operation) {
            $operationWidth = $this->calculateOperationWidth($operation);
            $width = $operationWidth > $width ? $operationWidth : $width;
        }

        return $width;
    }

    /**
     * @param Parameter $parameter
     * @return string
     */
    protected function getParameterString(Parameter $parameter) : string
    {
        return $parameter->getName() . ':' . $parameter->getType();
    }
}
