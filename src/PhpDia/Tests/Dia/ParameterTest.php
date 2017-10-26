<?php

namespace Dia;

use PhpDia\Dia\Xml\Parameter;
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testRenderParameter()
    {
        $parameter = Parameter::create('name', 'string')
            ->setValue('nico')
            ->setComment('Comment');

        $expected = file_get_contents(__DIR__ . '/stubs/parameter.stub.xml');
        $this->assertEquals($expected, $parameter->render());
    }
}
