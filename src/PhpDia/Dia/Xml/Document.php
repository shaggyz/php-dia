<?php

namespace PhpDia\Dia\Xml;

use DOMDocument;
use PhpDia\Dia\Exception\UnknownLayoutType;
use PhpDia\Dia\Layout\MosaicLayout;
use PhpDia\Dia\RenderItem;
use PhpDia\Dia\TemplateManager;

class Document implements RenderItem
{
    const TEMPLATE = 'document';

    /** @var Diagram */
    protected $diagram;

    /** @var Layer[] */
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
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->loadXML($rawXml);

        return $doc->saveXML();
    }

    /**
     * @return array
     */
    protected function getValues() : array
    {
        return [
            'diagram' => $this->diagram ? $this->diagram->render() : '',
            'layers' => $this->layers
        ];
    }

    public function applyLayout(int $layoutType)
    {
        switch ($layoutType) {
            case MosaicLayout::LAYOUT_TYPE:
                $layers = [];
                foreach ($this->layers as $layer) {
                    $layout = MosaicLayout::create($layer);
                    $layers[] = $layout->layout();
                }
                $this->layers = $layers;
                break;
            default:
                throw new UnknownLayoutType("Unknown layout type: $layoutType");
                break;
        }
    }
}
