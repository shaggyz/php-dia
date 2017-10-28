<?php

namespace PhpDia\Dia;

use PhpDia\Dia\Xml\Document;

class File
{
    /**
     * @var string
     */
    private $contents;

    /**
     * @param Document $document
     * @return File
     */
    public function setDocument(Document $document) : File
    {
        $this->contents = $document->render();
        return $this;
    }

    /**
     * @param string $filePath
     * @return bool
     */
    public function save(string $filePath, bool $compress = true) : bool
    {
        $contents = $this->contents;

        if ($compress) {
            $contents = $this->compress($contents);
        }

        if (file_put_contents($filePath, $contents)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getContents() : string
    {
        return $this->contents;
    }

    /**
     * @param string $contents
     * @return string
     */
    protected function compress(string $contents) : string
    {
        return gzencode($contents, 9);
    }
}