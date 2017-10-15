<?php

namespace PhpDia\Dia;

use DOMDocument;

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
        $rawXml = TemplateManager::create()->render(static::TEMPLATE, $this->getValues());
        return $this->formatXml($rawXml);
    }

    /**
     * @param string $rawXml
     * @return string
     */
    protected function formatXml(string $rawXml) : string
    {
        $doc = new DomDocument('1.0');
        $doc->loadXML($rawXml);
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        return $doc->saveXML();
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