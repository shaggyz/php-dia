<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Xml\Attribute;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{
    public function testRenderAttribute()
    {
        $attribute = Attribute::create('publicVar', 'int')
            ->setValue(5)
            ->setComment('Public int')
            ->setVisibility(Attribute::VISIBILITY_PUBLIC)
            ->setAbstract(true)
            ->setClassScope(true);

        $expected = file_get_contents(__DIR__ . '/stubs/attribute.stub.xml');

        $this->assertEquals($expected, $attribute->render());
    }
}
