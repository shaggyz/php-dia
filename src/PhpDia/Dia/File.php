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
     * @param string $filePath
     * @return bool
     */
    public function save(string $filePath, bool $compress = false) : bool
    {
        if ($compress) {
            $blob = $this->compress($this->contents);
        }

        return false;
    }

    /**
     * @return string
     */
    public function getFileName() : string
    {
        return $this->fileName . "." . $this->extension;
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