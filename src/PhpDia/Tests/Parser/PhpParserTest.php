<?php

namespace PhpDia\Tests\Parser;

use PhpDia\Parser\Parser;
use PHPUnit\Framework\TestCase;

class PhpParserTest extends TestCase
{
    /** @var Parser */
    private $parser;

    public function setUp()
    {
        parent::setUp();
        $this->parser = new Parser();
    }

    public function testParse()
    {
        $this->assertTrue($this->parser->parse(__DIR__ . '/Dummy.php'));
    }

    public function testGetNamespace()
    {
        $this->parser->parse(__DIR__ . '/Dummy.php');

        $expected = [
            'PhpDia',
            'Tests',
            'Parser',
        ];

        $this->assertEquals($expected, $this->parser->getNameSpace());
    }

    public function testGetNamespaceString()
    {
        $this->parser->parse(__DIR__ . '/Dummy.php');
        $this->assertEquals("PhpDia\\Tests\\Parser", $this->parser->getNameSpaceString());
    }

    public function testGetAst()
    {
        $this->parser->parse(__DIR__ . '/Dummy.php');
        $this->assertGreaterThan(0, count($this->parser->getAst()));
    }
}
