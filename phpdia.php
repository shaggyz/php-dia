#!/usr/bin/env php
<?php

include_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use PhpDia\Application\PhpDiaCommand;

$application = new Application(PhpDiaCommand::NAME, PhpDiaCommand::VERSION);

$application->add(new PhpDiaCommand());
$application->setDefaultCommand(PhpDiaCommand::NAME, true);

$application->run();
