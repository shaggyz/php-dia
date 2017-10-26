<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Xml\Diagram;
use PHPUnit\Framework\TestCase;

class DiagramTest extends TestCase
{
    public function testRenderDiagram()
    {
        $diagram = new Diagram();

        $diagram->setBackground('#666000')
            ->setPageBreakColor('#000666')
            ->setPaperName('Letter')
            ->setPortrait(false)
            ->setFitTo(true)
            ->setScaling(2);

        $expected = file_get_contents(__DIR__ . '/stubs/diagram.stub.xml');

        $this->assertEquals($expected, $diagram->render());
    }
}
