<?php

namespace PhpDia\Dia\Values;

class Position
{
    /**
     * @var float
     */
    private $x;

    /**
     * @var float
     */
    private $y;

    /**
     * @param float $x
     * @param float $y
     */
    private function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param float $x
     * @param float $y
     * @return Position
     */
    public static function create(float $x, float $y) : Position
    {
        return new static($x, $y);
    }

    /**
     * @return Position
     */
    public static function createEmpty() : Position
    {
        return new static(0 , 0);
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return strval($this->x) . ',' . strval($this->y);
    }

    /**
     * @return float
     */
    public function getX(): float
    {
        return $this->x;
    }

    /**
     * @param float $x
     * @return Position
     */
    public function setX(float $x): Position
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @return float
     */
    public function getY(): float
    {
        return $this->y;
    }

    /**
     * @param float $y
     * @return Position
     */
    public function setY(float $y): Position
    {
        $this->y = $y;
        return $this;
    }
}