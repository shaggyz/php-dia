<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testFileCreation()
    {
        $diaFile = new File('example');
        $this->assertEquals('example.dia', $diaFile->getFileName());

        $this->assertTrue($diaFile->save('/tmp'));
        $this->assertFileExists('/tmp/example.dia');
    }
}