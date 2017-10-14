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
     * @var Layer[]
     */
    protected $layers = [];

    /**
     * @param Diagram $diagram
     * @return $this
     */
    public function addDiagram(Diagram $diagram)
    {
        $this->diagram = $diagram;
        return $this;
    }

    /**
     * @param Layer $layer
     * @return $this
     */
    public function addLayer(Layer $layer)
    {
        $this->layers[] = $layer;
        return $this;
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

        return [
            'diagram' => $this->diagram->render(),
            'layers' => $this->layers
        ];
    }
}