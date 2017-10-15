<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\Document;
use PhpDia\Dia\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testFileCreation()
    {
        $diaFile = new File('example');
        $this->assertEquals('example.dia', $diaFile->getFileName());

        $documentProphecy = $this->prophesize(Document::class);
        $documentProphecy->render()->willReturn('document');

        /** @var Document $document */
        $document = $documentProphecy->reveal();

        $diaFile->setDocument($document);

        $this->assertTrue($diaFile->save('/tmp'));
        $this->assertFileExists('/tmp/example.dia');
    }
}