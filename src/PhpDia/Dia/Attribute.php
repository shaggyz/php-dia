<?php

namespace PhpDia\Dia;

class Attribute implements RenderItem
{
    const TEMPLATE = 'attribute';
    const VISIBILITY_PUBLIC = 0;
    const VISIBILITY_PRIVATE = 1;
    const VISIBILITY_PROTECTED = 2;

    /** @var string */
    protected $name;

    /** @var string */
    protected $type;

    /** @var string */
    protected $value = "";

    /** @var int */
    protected $visibility = self::VISIBILITY_PUBLIC;

    /** @var string */
    protected $comment = "";

    /** @var bool */
    protected $abstract = false;

    /** @var bool */
    protected $classScope = false;

    /**
     * @param string $name
     * @param string $type
     */
    private function __construct(string $name, string $type)
    {
        $this->setName($name);
        $this->setType($type);
    }

    /**
     * @param string $name
     * @param string $type
     * @return Attribute
     */
    public static function create(string $name, string $type) : Attribute
    {
        return new static($name, $type);
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
        return [
            'name' => $this->getName(),
            'type' => $this->getType(),
            'value' => $this->getValue(),
            'visibility' => $this->getVisibility(),
            'comment' => $this->getComment(),
            'abstract' => $this->isAbstract() ? 'true' : 'false',
            'classScope' => $this->isClassScope() ? 'true' : 'false'
        ];
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
     * @return Attribute
     */
    public function setName(string $name): Attribute
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Attribute
     */
    public function setType(string $type): Attribute
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Attribute
     */
    public function setValue(string $value): Attribute
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getVisibility(): int
    {
        return $this->visibility;
    }

    /**
     * @param int $visibility
     * @return Attribute
     */
    public function setVisibility(int $visibility): Attribute
    {
        $this->visibility = $visibility;
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
     * @return Attribute
     */
    public function setComment(string $comment): Attribute
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
     * @return Attribute
     */
    public function setAbstract(bool $abstract): Attribute
    {
        $this->abstract = $abstract;
        return $this;
    }

    /**
     * @return bool
     */
    public function isClassScope(): bool
    {
        return $this->classScope;
    }

    /**
     * @param bool $classScope
     * @return Attribute
     */
    public function setClassScope(bool $classScope): Attribute
    {
        $this->classScope = $classScope;
        return $this;
    }
}