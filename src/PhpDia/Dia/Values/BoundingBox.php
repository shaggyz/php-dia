<?php

namespace PhpDia\Dia\Values;

class BoundingBox
{
    /** @var float */
    private $left;

    /** @var float */
    private $right;

    /** @var float */
    private $top;

    /** @var float */
    private $bottom;

    /**
     * @param float $left
     * @param float $right
     * @param float $top
     * @param float $bottom
     */
    private function __construct(float $left, float $right, float $top, float $bottom)
    {
        $this->left = $left;
        $this->right = $right;
        $this->top = $top;
        $this->bottom = $bottom;
    }

    /**
     * @param float $left
     * @param float $right
     * @param float $top
     * @param float $bottom
     * @return BoundingBox
     */
    public static function create(float $left, float $right, float $top, float $bottom) : BoundingBox
    {
        return new static($left, $right, $top, $bottom);
    }

    /**
     * @return BoundingBox
     */
    public static function createEmpty() : BoundingBox
    {
        return new static(0, 0, 0, 0);
    }

    /**
     * @return float
     */
    public function getLeft(): float
    {
        return $this->left;
    }

    /**
     * @param float $left
     * @return BoundingBox
     */
    public function setLeft(float $left): BoundingBox
    {
        $this->left = $left;
        return $this;
    }

    /**
     * @return float
     */
    public function getRight(): float
    {
        return $this->right;
    }

    /**
     * @param float $right
     * @return BoundingBox
     */
    public function setRight(float $right): BoundingBox
    {
        $this->right = $right;
        return $this;
    }

    /**
     * @return float
     */
    public function getTop(): float
    {
        return $this->top;
    }

    /**
     * @param float $top
     * @return BoundingBox
     */
    public function setTop(float $top): BoundingBox
    {
        $this->top = $top;
        return $this;
    }

    /**
     * @return float
     */
    public function getBottom(): float
    {
        return $this->bottom;
    }

    /**
     * @param float $bottom
     * @return BoundingBox
     */
    public function setBottom(float $bottom): BoundingBox
    {
        $this->bottom = $bottom;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return strval($this->left) . ',' .
            strval($this->right) . ';' .
            strval($this->top) . ',' .
            strval($this->bottom);
    }
}