<?php

include_once __DIR__ . '/vendor/autoload.php';

use PhpDia\Dia\File;
use PhpDia\Dia\Document;
use PhpDia\Dia\Diagram;
use PhpDia\Dia\Layer;
use PhpDia\Dia\ClassElement;
use PhpDia\Dia\Attribute;
use PhpDia\Dia\Operation;
use PhpDia\Dia\Parameter;

$document = new Document();
$diagram = new Diagram();
$layer = new Layer();

$class = ClassElement::create('MyClass')
    ->addAttribute(Attribute::create('name', 'string'))
    ->addOperation(Operation::create('getName', 'string'))
    ->addOperation(
        Operation::create('setName')
            ->addParameter(Parameter::create('name', 'string'))
    );

$layer->addElement($class);

$document->addDiagram($diagram);
$document->addLayer($layer);

$file = new File('test');
$file->setDocument($document);
$file->save('/tmp');
