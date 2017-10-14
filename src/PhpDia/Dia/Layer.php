<?php

namespace PhpDia\Dia;

class Layer implements RenderItem
{
    const TEMPLATE = 'layer';

    /** @var string */
    protected $name = 'Background';

    /** @var bool */
    protected $visible = true;

    /** @var bool */
    protected $active = true;

    /** @var Element[] */
    protected $elements = [];

    /**
     * @return string
     */
    public function render(): string
    {
        return TemplateManager::create()->render(static::TEMPLATE, $this->getValues());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Layer
     */
    public function setName(string $name): Layer
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     * @return Layer
     */
    public function setVisible(bool $visible): Layer
    {
        $this->visible = $visible;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Layer
     */
    public function setActive(bool $active): Layer
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @param Element $element
     * @return Layer
     */
    public function addElement(Element $element): Layer
    {
        $this->elements[] = $element;
        return $this;
    }

    /**
     * @return array
     */
    protected function getValues() : array
    {
        return [
            'name' => $this->getName(),
            'visible' => $this->isVisible() ? 'true' : 'false',
            'active' => $this->isActive() ? 'true' : 'false',
            'elements' => $this->elements
        ];
    }

}