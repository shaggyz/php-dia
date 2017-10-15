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
use PhpDia\Dia\Values\BoundingBox;
use PhpDia\Dia\Values\Position;

$document = new Document();
$diagram = new Diagram();
$layer = new Layer();

$myClass = ClassElement::create('MyClass')
    ->addAttribute(Attribute::create('name', 'string'))
    ->addOperation(Operation::create('getName', 'string'))
    ->addOperation(
        Operation::create('setName')
            ->addParameter(Parameter::create('name', 'string'))
    );

$yourClass = ClassElement::create('YourClass')
    ->addAttribute(Attribute::create('title', 'string'))
    ->addOperation(Operation::create('getTitle', 'string'))
    ->addOperation(
        Operation::create('setTitle')
            ->addParameter(Parameter::create('title', 'string'))
    )
    ->addOperation(
        Operation::create('isActive', 'bool')
            ->setVisibility(Attribute::VISIBILITY_PROTECTED)
    );

$layer->addElement($myClass);
$layer->addElement($yourClass);

$document->addDiagram($diagram);
$document->addLayer($layer);

$file = new File('test');
$file->setDocument($document);
$file->save('/tmp');
