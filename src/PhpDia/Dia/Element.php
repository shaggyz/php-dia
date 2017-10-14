<?php

namespace PhpDia\Dia;

use PhpDia\Dia\Values\BoundingBox;
use PhpDia\Dia\Values\Position;

class Element implements RenderItem
{
    const TEMPLATE = 'element';

    /** @var Position */
    protected $position;

    /** @var BoundingBox */
    protected $boundingBox;

    /** @var Position */
    protected $corner;

    /** @var float */
    protected $width;

    /** @var float */
    protected $height;

    /** @var string */
    protected $name;

    /** @var string */
    protected $comment = '';

    /** @var bool */
    protected $abstract = false;

    /** @var bool */
    protected $suppressAttributes = false;

    /** @var bool */
    protected $suppressOperations = false;

    /** @var bool */
    protected $visibleAttributes = true;

    /** @var bool */
    protected $visibleOperations = true;

    /** @var bool */
    protected $visibleComments = false;

    /** @var bool */
    protected $wrapOperations = true;

    /** @var string */
    protected $lineColor = '#000000';

    /** @var string */
    protected $fillColor = '#ffffff';

    /** @var string */
    protected $textColor = '#000000';

    /** @var Attribute[] */
    protected $attributes = [];

    /** @var Operation[] */
    protected $operations = [];

    /**
     * @param string $name
     */
    private function __construct(string $name)
    {
        $this->setName($name);
        $this->setPosition(Position::create(1.5, 3.5));
        $this->setCorner($this->getPosition());
        $this->setWidth(13.2);
        $this->setHeight(5.8);
    }

    /**
     * @param string $name
     * @return Element
     */
    public static function create(string $name) : Element
    {
        return new static($name);
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
    public function getValues() : array
    {
        return [
            'position' => $this->position,
            'boundingBox' => $this->boundingBox,
            'corner' => $this->getCorner(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'name' => $this->getName(),
            'comment' => $this->getComment(),
            'abstract' => $this->isAbstract() ? 'true' : 'false',
            'suppressAttributes' => $this->isSuppressAttributes() ? 'true' : 'false',
            'suppressOperations' => $this->isSuppressOperations() ? 'true' : 'false',
            'visibleAttributes' => $this->isVisibleAttributes() ? 'true' : 'false',
            'visibleOperations' => $this->isVisibleOperations() ? 'true' : 'false',
            'visibleComments' => $this->isVisibleComments() ? 'true' : 'false',
            'wrapOperations' => $this->isWrapOperations() ? 'true' : 'false',
            'lineColor' => $this->getLineColor(),
            'fillColor' => $this->getFillColor(),
            'textColor' => $this->getTextColor(),
            'attributes' => $this->attributes,
            'operations' => $this->operations
        ];
    }

    /**
     * @param Attribute $attribute
     * @return Element
     */
    public function addAttribute(Attribute $attribute) : Element
    {
        $this->attributes[] = $attribute;
        return $this;
    }

    /**
     * @param Operation $operation
     * @return Element
     */
    public function addOperation(Operation $operation) : Element
    {
        $this->operations[] = $operation;
        return $this;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @param Position $position
     * @return Element
     */
    public function setPosition(Position $position): Element
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return BoundingBox
     */
    public function getBoundingBox(): BoundingBox
    {
        return $this->boundingBox;
    }

    /**
     * @param BoundingBox $boundingBox
     * @return Element
     */
    public function setBoundingBox(BoundingBox $boundingBox): Element
    {
        $this->boundingBox = $boundingBox;
        return $this;
    }

    /**
     * @return Position
     */
    public function getCorner(): Position
    {
        return $this->corner;
    }

    /**
     * @param Position $corner
     * @return Element
     */
    public function setCorner(Position $corner): Element
    {
        $this->corner = $corner;
        return $this;
    }

    /**
     * @return float
     */
    public function getWidth(): float
    {
        return $this->width;
    }

    /**
     * @param float $width
     * @return Element
     */
    public function setWidth(float $width): Element
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * @param float $height
     * @return Element
     */
    public function setHeight(float $height): Element
    {
        $this->height = $height;
        return $this;
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
     * @return Element
     */
    public function setName(string $name): Element
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Element
     */
    public function setComment(string $comment): Element
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * @param bool $abstract
     * @return Element
     */
    public function setAbstract(bool $abstract): Element
    {
        $this->abstract = $abstract;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuppressAttributes(): bool
    {
        return $this->suppressAttributes;
    }

    /**
     * @param bool $suppressAttributes
     * @return Element
     */
    public function setSuppressAttributes(bool $suppressAttributes): Element
    {
        $this->suppressAttributes = $suppressAttributes;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuppressOperations(): bool
    {
        return $this->suppressOperations;
    }

    /**
     * @param bool $suppressOperations
     * @return Element
     */
    public function setSuppressOperations(bool $suppressOperations): Element
    {
        $this->suppressOperations = $suppressOperations;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVisibleAttributes(): bool
    {
        return $this->visibleAttributes;
    }

    /**
     * @param bool $visibleAttributes
     * @return Element
     */
    public function setVisibleAttributes(bool $visibleAttributes): Element
    {
        $this->visibleAttributes = $visibleAttributes;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVisibleOperations(): bool
    {
        return $this->visibleOperations;
    }

    /**
     * @param bool $visibleOperations
     * @return Element
     */
    public function setVisibleOperations(bool $visibleOperations): Element
    {
        $this->visibleOperations = $visibleOperations;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVisibleComments(): bool
    {
        return $this->visibleComments;
    }

    /**
     * @param bool $visibleComments
     * @return Element
     */
    public function setVisibleComments(bool $visibleComments): Element
    {
        $this->visibleComments = $visibleComments;
        return $this;
    }

    /**
     * @return bool
     */
    public function isWrapOperations(): bool
    {
        return $this->wrapOperations;
    }

    /**
     * @param bool $wrapOperations
     * @return Element
     */
    public function setWrapOperations(bool $wrapOperations): Element
    {
        $this->wrapOperations = $wrapOperations;
        return $this;
    }

    /**
     * @return string
     */
    public function getLineColor(): string
    {
        return $this->lineColor;
    }

    /**
     * @param string $lineColor
     * @return Element
     */
    public function setLineColor(string $lineColor): Element
    {
        $this->lineColor = $lineColor;
        return $this;
    }

    /**
     * @return string
     */
    public function getFillColor(): string
    {
        return $this->fillColor;
    }

    /**
     * @param string $fillColor
     * @return Element
     */
    public function setFillColor(string $fillColor): Element
    {
        $this->fillColor = $fillColor;
        return $this;
    }

    /**
     * @return string
     */
    public function getTextColor(): string
    {
        return $this->textColor;
    }

    /**
     * @param string $textColor
     * @return Element
     */
    public function setTextColor(string $textColor): Element
    {
        $this->textColor = $textColor;
        return $this;
    }
}