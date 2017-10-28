<?php

namespace PhpDia\Application\Event;

class TotalFilesAcquiredEvent extends BaseEvent
{
    /** @var int */
    protected $total;

    /** @var string */
    protected $path;

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     * @return TotalFilesAcquiredEvent
     */
    public function setTotal(int $total): TotalFilesAcquiredEvent
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return TotalFilesAcquiredEvent
     */
    public function setPath(string $path): TotalFilesAcquiredEvent
    {
        $this->path = $path;
        return $this;
    }

    /**
     * TotalFilesAcquiredEvent constructor.
     * @param int $total
     * @param string $path
     */
    private function __construct(int $total, string $path)
    {
        $this->total = $total;
        $this->path = $path;
    }

    /**
     * @param int $total
     * @param string $path
     * @return TotalFilesAcquiredEvent
     */
    public static function create(int $total, string $path) : TotalFilesAcquiredEvent
    {
        return new static($total, $path);
    }
}