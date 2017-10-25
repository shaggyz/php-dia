<?php

namespace PhpDia\Application;

use PhpDia\Application\Exception\EmptyFileListException;
use PhpDia\Application\Exception\MissingSourceFileException;
use PhpDia\Dia\File;
use PhpDia\Dia\Layout\MosaicLayout;
use PhpDia\Dia\Xml\ClassElement;
use PhpDia\Dia\Xml\Diagram;
use PhpDia\Dia\Xml\Document;
use PhpDia\Dia\Xml\Element;
use PhpDia\Dia\Xml\Layer;
use PhpDia\Dia\Xml\Operation;
use PhpDia\Dia\Xml\Parameter;
use PhpDia\Parser\Parser;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;

class Generator
{
    /** @var Parser */
    protected $parser;

    /** @var File  */
    protected $file;

    /** @var string */
    protected $sourcePath;

    /** @var array */
    protected $excluded = [];

    /** @var int */
    protected $objectIdentifier = -1;

    public function __construct(string $fileName, string $sourcePath)
    {
        $this->parser = new Parser();
        $this->file = new File($fileName);
        $this->sourcePath = $sourcePath;
    }

    public function generate()
    {
        $files = $this->getFileList();

        if (!count($files)) {
            throw new EmptyFileListException(
                sprintf("No php files found in '%s'", $this->sourcePath)
            );
        }

        $document = new Document();
        $diagram = new Diagram();
        $layer = new Layer();

        foreach ($files as $file) {
            $this->parser->parse($file);
            $elements = $this->processAst($this->parser->getAst());
            $layer->addElements($elements);
        }

        $document->addDiagram($diagram);
        $document->addLayer($layer);
        $document->applyLayout(MosaicLayout::LAYOUT_TYPE);

        $this->file->setDocument($document);
        $this->file->save(__DIR__ . "/../../../");
    }

    /**
     * @param array $ast
     * @return array
     */
    private function processAst(array $ast) : array
    {
        $elements = [];

        foreach ($ast as $meta) {
            foreach ($meta->stmts as $stmt) {
                switch (get_class($stmt)) {
                    case "PhpParser\Node\Stmt\Class_":
                        $elements[] = $this->processElement($stmt);
                        break;
                    case "PhpParser\Node\Stmt\Use_":
                        continue;
                        break;
                    default:
                        echo "Error: unknown type: " . get_class($stmt) . "\n";
                        break;
                }
            }
        }

        return $elements;
    }

    /**
     * @param Class_ $node
     * @return Element
     */
    private function processElement(Class_ $node) : Element
    {
        $this->objectIdentifier++;
        $classElement = ClassElement::create($node->name->name, $this->objectIdentifier);

        foreach ($node->stmts as $classStmt) {
            switch (get_class($classStmt)) {
                case "PhpParser\Node\Stmt\ClassMethod":
                    /** @var ClassMethod $classStmt */
                    $classElement->addOperation($this->processMethod($classStmt));
                    break;
                case "PhpParser\Node\Stmt\ClassConst":
                    /** @var ClassConst $classStmt */
                    break;
                case "PhpParser\Node\Stmt\Property":
                    /** @var Property $classStmt */
                    break;
                default:
                    echo "Error: unknown class smt type: " . get_class($classStmt) . "\n";
                    break;
            }
        }

        return $classElement;
    }

    /**
     * @param ClassMethod $classMethod
     * @return Operation
     */
    private function processMethod(ClassMethod $classMethod) : Operation
    {
        $operation = Operation::create($classMethod->name->name);
        if ($classMethod->returnType) {
            $operation->setType($classMethod->returnType);
        }
        if (count($classMethod->params)) {
            foreach ($classMethod->params as $param) {
                $type = isset($param->type->parts) ? implode($param->type->parts) : 'mixed';
                $parameter = Parameter::create($param->var->name, $type);
                $operation->addParameter($parameter);
            }
        }
        return $operation;
    }

   /**
    * @return array
    */
    protected function getFileList() : array
    {
        if (!file_exists($this->sourcePath)) {
            throw new MissingSourceFileException(
                sprintf("The source directory/file %s is missing.", $this->sourcePath)
            );
        }

        if (!is_dir($this->sourcePath) && file_exists($this->sourcePath)) {
            return [
                $this->sourcePath
            ];
        }

        $directory = new \RecursiveDirectoryIterator($this->sourcePath);
        $iterator = new \RecursiveIteratorIterator($directory);
        $regex = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

        $files = [];
        foreach ($regex as $file) {
            $filePath = $file[0];
            if ($this->isFilePathExcluded($filePath)) {
                continue;
            }
            $files[] = $filePath;
        }

        return $files;
    }

    /**
     * @param string $filePath
     * @return bool
     */
    protected function isFilePathExcluded(string $filePath) : bool
    {
        if (!count($this->excluded)) {
            return false;
        }

        foreach ($this->excluded as $excludedDir) {
            $excludedDir = false === strpos($excludedDir, './') ? './' . $excludedDir : $excludedDir;
            if (strpos($filePath, $excludedDir) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getExcluded(): array
    {
        return $this->excluded;
    }

    /**
     * @param array $excluded
     * @return Generator
     */
    public function setExcluded(array $excluded): Generator
    {
        $this->excluded = $excluded;
        return $this;
    }
}
