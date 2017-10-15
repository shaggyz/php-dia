<?php

namespace PhpDia\Dia\Xml;

use PhpDia\Dia\RenderItem;
use PhpDia\Dia\TemplateManager;

class Diagram implements RenderItem
{
    const TEMPLATE = 'diagram';

    /** @var string */
    protected $background = '#ffffff';

    /** @var string */
    protected $pageBreakColor = '#000099';

    /** @var string */
    protected $paperName = 'A4';

    /** @var bool */
    protected $portrait = true;

    /** @var int */
    protected $scaling = 1;

    /** @var bool */
    protected $fitTo = false;

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
        return [
            'background' => $this->getBackground(),
            'pageBreakColor' => $this->getPageBreakColor(),
            'paperName' => $this->getPaperName(),
            'portrait' => $this->isPortrait() ? 'true' : 'false',
            'scaling' => $this->getScaling(),
            'fitTo' => (string) $this->isFitTo() ? 'true' : 'false'
        ];
    }

    /**
     * @return string
     */
    public function getBackground(): string
    {
        return $this->background;
    }

    /**
     * @param string $background
     * @return Diagram
     */
    public function setBackground(string $background): Diagram
    {
        $this->background = $background;
        return $this;
    }

    /**
     * @return string
     */
    public function getPageBreakColor(): string
    {
        return $this->pageBreakColor;
    }

    /**
     * @param string $pageBreakColor
     * @return Diagram
     */
    public function setPageBreakColor(string $pageBreakColor): Diagram
    {
        $this->pageBreakColor = $pageBreakColor;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaperName(): string
    {
        return $this->paperName;
    }

    /**
     * @param string $paperName
     * @return Diagram
     */
    public function setPaperName(string $paperName): Diagram
    {
        $this->paperName = $paperName;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPortrait(): bool
    {
        return $this->portrait;
    }

    /**
     * @param bool $portrait
     * @return Diagram
     */
    public function setPortrait(bool $portrait): Diagram
    {
        $this->portrait = $portrait;
        return $this;
    }

    /**
     * @return int
     */
    public function getScaling(): int
    {
        return $this->scaling;
    }

    /**
     * @param int $scaling
     * @return Diagram
     */
    public function setScaling(int $scaling): Diagram
    {
        $this->scaling = $scaling;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFitTo(): bool
    {
        return $this->fitTo;
    }

    /**
     * @param bool $fitTo
     * @return Diagram
     */
    public function setFitTo(bool $fitTo): Diagram
    {
        $this->fitTo = $fitTo;
        return $this;
    }


}