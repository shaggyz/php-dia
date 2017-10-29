<?php

namespace PhpDia\Application\Event;

class FileParsedEvent extends BaseEvent
{
    /** @var string */
    protected $fileName;

    /**
     * @param string $fileName
     */
    private function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param string $fileName
     * @return static
     */
    public static function create(string $fileName)
    {
        return new static($fileName);
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return FileParsedEvent
     */
    public function setFileName(string $fileName) : FileParsedEvent
    {
        $this->fileName = $fileName;
        return $this;
    }
}