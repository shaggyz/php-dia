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

        $expected = <<<EOL
<?xml version="1.0" encoding="UTF-8"?>
<dia:diagram xmlns:dia="http://www.lysator.liu.se/~alla/dia/">
    diagram
    layers
    layers
</dia:diagram>

EOL;

        $this->assertEquals($expected, $document->render());
    }
}
