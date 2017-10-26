<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Xml\Diagram;
use PhpDia\Dia\Xml\Document;
use PhpDia\Dia\Xml\Layer;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function testRenderDocument()
    {
        $diagramProphecy = $this->prophesize(Diagram::class);
        $diagramProphecy->render()->willReturn('diagram');

        $layerProphecy = $this->prophesize(Layer::class);
        $layerProphecy->render()->willReturn('layers');

        $document = new Document();
        $document->addDiagram($diagramProphecy->reveal())
            ->addLayer($layerProphecy->reveal())
            ->addLayer($layerProphecy->reveal());

        $expected = file_get_contents(__DIR__ . '/stubs/document.stub.xml');
        $this->assertEquals($expected, $document->render());
    }
}
