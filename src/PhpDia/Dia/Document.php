<?php

namespace PhpDia\Dia;

class Document implements RenderItem
{
    const TEMPLATE = 'document';

    /**
     * @var Diagram
     */
    protected $diagram;

    /**
     * @param Diagram $diagram
     */
    public function addDiagram(Diagram $diagram)
    {
        $this->diagram = $diagram;
    }

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
    protected function getValues() : array
    {
        $values = [];

        if ($this->diagram) {
            $values['diagram'] = $this->diagram->render();
        }

        return $values;
    }

}