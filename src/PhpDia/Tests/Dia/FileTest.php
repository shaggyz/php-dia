<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Xml\Document;
use PhpDia\Dia\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testFileCreation()
    {
        $diaFile = new File();

        $documentProphecy = $this->prophesize(Document::class);
        $documentProphecy->render()->willReturn('document');

        /** @var Document $document */
        $document = $documentProphecy->reveal();

        $diaFile->setDocument($document);

        $this->assertTrue($diaFile->save('/tmp/example.dia'));
        $this->assertFileExists('/tmp/example.dia');
    }
}