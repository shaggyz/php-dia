<?php

namespace PhpDia\Application\Event;

use League\Event\EmitterInterface;
use League\Event\EventInterface;

class BaseEvent implements EventInterface
{
    /** @var EmitterInterface */
    protected $emitter;

    /** @var bool */
    protected $stopPropagation = false;

    /**
     * Set the Emitter.
     *
     * @param EmitterInterface $emitter
     *
     * @return $this
     */
    public function setEmitter(EmitterInterface $emitter) : BaseEvent
    {
        $this->emitter = $emitter;
        return $this;
    }

    /**
     * Get the Emitter.
     *
     * @return EmitterInterface
     */
    public function getEmitter() : EmitterInterface
    {
        return $this->emitter;
    }

    /**
     * Stop event propagation.
     *
     * @return $this
     */
    public function stopPropagation() : BaseEvent
    {
        $this->stopPropagation = true;
        return $this;
    }

    /**
     * Check whether propagation was stopped.
     *
     * @return bool
     */
    public function isPropagationStopped() : bool
    {
        return $this->stopPropagation;
    }

    /**
     * @return string
     */
    public function getName()
    {
        $reflection = new \ReflectionClass($this);
        return $reflection->getShortName();
    }
}
