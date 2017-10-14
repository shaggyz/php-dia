<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Diagram;
use PhpDia\Dia\Document;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function testRenderDocument()
    {
        $diagramProphecy = $this->prophesize(Diagram::class);
        $diagramProphecy->render()->willReturn('render');

        $document = new Document();
        $document->addDiagram($diagramProphecy->reveal());

        $expected = <<<EOL
<?xml version="1.0" encoding="UTF-8"?>
<dia:diagram xmlns:dia="http://www.lysator.liu.se/~alla/dia/">
    render
</dia:diagram>
EOL;

        $this->assertEquals($expected, $document->render());
    }
}