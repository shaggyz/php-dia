<?php

namespace PhpDia\Dia;

use PhpDia\Dia\Values\Position;

class Element implements RenderItem
{
    const TEMPLATE = 'element';

    /** @var Position */
    protected $position;

    /**
     * @return string
     */
    public function render(): string
    {
        return TemplateManager::create()->render(static::TEMPLATE, $this->getValues());
    }

    /**
     * @return array
     */
    public function getValues() : array
    {
        return [

        ];
    }
}