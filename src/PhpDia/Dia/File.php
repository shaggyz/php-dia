<?php

namespace PhpDia\Dia;

class File
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @var string
     */
    private $contents;

    /**
     * @param string $fileName
     * @param string $extension
     */
    public function __construct(string $fileName, string $extension = 'dia')
    {
        $this->fileName = $fileName;
        $this->extension = $extension;
    }

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
    public function save(string $filePath, bool $compress = false) : bool
    {
        $contents = $this->contents;

        if ($compress) {
            $contents = $this->compress($contents);
        }

        if (file_put_contents($this->getFileName($filePath), $contents)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getFileName(string $path = "") : string
    {
        if (!empty($path) && $path[strlen($path) - 1] !== DIRECTORY_SEPARATOR) {
            $path = $path . DIRECTORY_SEPARATOR;
        }

        return $path . $this->fileName . "." . $this->extension;
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
        return $contents;
    }
}