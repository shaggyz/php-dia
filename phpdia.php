<?php

include_once __DIR__ . '/vendor/autoload.php';

use PhpDia\Dia\File;
use PhpDia\Dia\Xml\Document;
use PhpDia\Dia\Xml\Diagram;
use PhpDia\Dia\Xml\Layer;
use PhpDia\Dia\Xml\ClassElement;
use PhpDia\Dia\Xml\Attribute;
use PhpDia\Dia\Xml\Operation;
use PhpDia\Dia\Xml\Parameter;
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
    )
    ->calculateGeometry();

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
    )
    ->calculateGeometry();

$layer->addElement($myClass);
$layer->addElement($yourClass);

$document->addDiagram($diagram);
$document->addLayer($layer);

$file = new File('test');
$file->setDocument($document);
$file->save('/tmp');
