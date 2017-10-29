<?php

namespace PhpDia\Application\Event;

use League\Event\EventInterface;

class MessageEvent extends BaseEvent implements EventInterface
{
    /** @var string */
    protected $message;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return BaseEvent
     */
    public function setMessage(string $message): BaseEvent
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param string $message
     */
    private function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @param string $message
     * @return BaseEvent
     */
    public static function create(string $message) : BaseEvent
    {
        return new static($message);
    }
}