<?php

namespace PhpDia\Dia\Xml;

use PhpDia\Dia\Exception\DuplicatedElementIdentifierException;
use PhpDia\Dia\Exception\ElementNotFound;
use PhpDia\Dia\RenderItem;
use PhpDia\Dia\TemplateManager;

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
     * @throws DuplicatedElementIdentifierException
     */
    public function addElement(Element $element): Layer
    {
        if (array_key_exists($element->getId(), $this->elements)) {
            throw new DuplicatedElementIdentifierException(
                sprintf("There is already an element with the id %s", $element->getId())
            );
        }
        $this->elements[$element->getId()] = $element;
        return $this;
    }

    /**
     * @param array $elements
     * @return Layer
     */
    public function addElements(array $elements) : Layer
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
        return $this;
    }

    /**
     * @param int $id
     * @return Element
     * @throws ElementNotFound
     */
    public function getElementById(int $id) : Element
    {
        if (!array_key_exists($id, $this->elements)) {
            throw new ElementNotFound('Missing element with id: ' . $id);
        }

        return $this->elements[$id];
    }

    /**
     * @param int $id
     * @param Element $element
     * @return Layer
     */
    public function updateElement(int $id, Element $element) : Layer
    {
        $this->getElementById($id);
        $this->elements[$id] = $element;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasElements() : bool
    {
        return count($this->elements) > 0;
    }

    /**
     * @return array
     */
    public function getElements() : array
    {
        return $this->elements;
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
