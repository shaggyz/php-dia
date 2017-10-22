<?php

namespace PhpDia\Parser;

use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;

class Parser
{
    /** @var array */
    protected $ast;

    /**
     * @see https://github.com/nikic/PHP-Parser
     * @throws ParserException
     * @param string $filePath
     * @return bool
     */
    public function parse(string $filePath) : bool
    {
        $contents = file_get_contents($filePath);
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

        try {
            $this->ast = $parser->parse($contents);
            return true;
        } catch (Error $error) {
            throw new ParserException(
                sprintf("Parse error: %s\n", $error->getMessage())
            );
        }
    }

    /**
     * @return array
     */
    public function getNameSpace() : array
    {
        $this->checkIsParsed();
        return $this->ast[0]->name->parts;
    }

    /**
     * @return array
     */
    public function getAst() : array
    {
        $this->checkIsParsed();
        return $this->ast;
    }

    /**
     * @return string
     */
    public function getNameSpaceString() : string
    {
        return implode("\\", $this->getNameSpace());
    }

    /**
     * @throws ParserException
     */
    protected function checkIsParsed()
    {
        if (!count($this->ast)) {
            throw new ParserException("You need to call parse() before.");
        }
    }
}
