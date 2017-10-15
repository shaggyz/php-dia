<?php

namespace PhpDia\Parser;

class PhpParser
{
    /**
     * @param string $filePath
     * @return bool
     */
    public function parse(string $filePath) : bool
    {
        $contents = file_get_contents($filePath);

        //https://github.com/nikic/PHP-Parser

        return false;
    }

    protected function tokenize(string $contents)
    {
        $tokens = token_get_all($contents);
        foreach ($tokens as $token) {
            if (is_array($token)) {
                echo "Line {$token[2]}: ", token_name($token[0]), " ('{$token[1]}')", PHP_EOL;
            }
        }
    }
}