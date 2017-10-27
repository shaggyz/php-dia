<?php

namespace PhpDia\Tests\Parser;

/**
 * This file is used only for the parser
 */
class Dummy
{
    /** @var string */
    public $publicProperty;

    /** @var int */
    protected $protectedProperty = 2;

    /** @var bool */
    private $privateProperty;

    /**
     * @param string $property
     * @return $this
     */
    public function publicMethod(string $property) : Dummy
    {
        $this->publicProperty = $property;
        return $this;
    }

    /**
     * @param string $param1
     * @param string $param2
     */
    protected function protectedMethod(
        string $param1,
        string $param2
    ) {
        $this->protectedProperty = $param1;
        $this->privateProperty = $param2;
    }
}
