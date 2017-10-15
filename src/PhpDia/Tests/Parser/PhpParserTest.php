<?php

namespace PhpDia\Tests\Parser;

use PhpDia\Parser\PhpParser;
use PHPUnit\Framework\TestCase;

class PhpParserTest extends TestCase
{
    public function testParse()
    {
        $parser = new PhpParser();

        $this->assertTrue($parser->parse(__DIR__ . '/Dummy.php'));
    }
}