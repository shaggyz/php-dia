<?php

namespace PhpDia\Dia;

class Operation implements RenderItem
{
    const TEMPLATE = 'operation';
    const INHERITANCE_UNKNOWN = 2;

    /** @var string */
    protected $name;

    /** @var string */
    protected $type;

    /** @var int */
    protected $visibility = Attribute::VISIBILITY_PUBLIC;

    /** @var string */
    protected $comment = "";

    /** @var int */
    protected $inheritance = self::INHERITANCE_UNKNOWN;

    /** @var bool */
    protected $abstract = false;

    /** @var bool */
    protected $query = false;

    /** @var bool */
    protected $classScope = false;

    /** @var Parameter */
    protected $parameters = [];

    /**
     * @param string $name
     * @param string $type
     */
    private function __construct(string $name, string $type = 'void')
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @param string $name
     * @param string $type
     * @return Operation
     */
    public static function create(string $name, string $type = 'void') : Operation
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
     * @param Parameter $parameter
     * @return Operation
     */
    public function addParameter(Parameter $parameter) : Operation
    {
        $this->parameters[] = $parameter;
        return $this;
    }

    /**
     * @return array
     */
    protected function getValues() : array
    {
        return [
            'name' => $this->getName(),
            'type' => $this->getType(),
            'visibility' => $this->getVisibility(),
            'comment' => $this->getComment(),
            'abstract' => $this->isAbstract() ? 'true' : 'false',
            'inheritance' => $this->getInheritance(),
            'query' => $this->isQuery() ? 'true' : 'false',
            'classScope' => $this->isClassScope() ? 'true' : 'false',
            'parameters' => $this->parameters
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
     * @return Operation
     */
    public function setName(string $name): Operation
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
     * @return Operation
     */
    public function setType(string $type): Operation
    {
        $this->type = $type;
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
     * @return Operation
     */
    public function setVisibility(int $visibility): Operation
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
     * @return Operation
     */
    public function setComment(string $comment): Operation
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return int
     */
    public function getInheritance(): int
    {
        return $this->inheritance;
    }

    /**
     * @param int $inheritance
     * @return Operation
     */
    public function setInheritance(int $inheritance): Operation
    {
        $this->inheritance = $inheritance;
        return $this;
    }

    /**
     * @return bool
     */
    public function isQuery(): bool
    {
        return $this->query;
    }

    /**
     * @param bool $query
     * @return Operation
     */
    public function setQuery(bool $query): Operation
    {
        $this->query = $query;
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
     * @return Operation
     */
    public function setClassScope(bool $classScope): Operation
    {
        $this->classScope = $classScope;
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
     * @return Operation
     */
    public function setAbstract(bool $abstract): Operation
    {
        $this->abstract = $abstract;
        return $this;
    }
}