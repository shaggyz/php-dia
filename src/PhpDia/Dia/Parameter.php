<?php

namespace PhpDia\Dia;

class Parameter implements RenderItem
{
    const TEMPLATE = 'parameter';
    const UNKNOWN_KIND = 0;

    /** @var string */
    protected $name;

    /** @var string */
    protected $type;

    /** @var string */
    protected $value;

    /** @var string */
    protected $comment;

    /** @var int */
    protected $kind = self::UNKNOWN_KIND;

    /**
     * @param string $name
     * @param string $type
     */
    private function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @param string $name
     * @param string $type
     * @return Parameter
     */
    public static function create(string $name, string $type) : Parameter
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
            'comment' => $this->getComment(),
            'kind' => $this->getKind()
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
     * @return Parameter
     */
    public function setName(string $name): Parameter
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
     * @return Parameter
     */
    public function setType(string $type): Parameter
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
     * @return Parameter
     */
    public function setValue(string $value): Parameter
    {
        $this->value = $value;
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
     * @return Parameter
     */
    public function setComment(string $comment): Parameter
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return int
     */
    public function getKind(): int
    {
        return $this->kind;
    }

    /**
     * @param int $kind
     * @return Parameter
     */
    public function setKind(int $kind): Parameter
    {
        $this->kind = $kind;
        return $this;
    }
}