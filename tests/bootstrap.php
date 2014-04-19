<?php

require __DIR__ . '/../vendor/autoload.php';

if (!class_exists('Tester\Assert')) {
	echo "Install Nette Tester using `composer update --dev`\n";
	exit(1);
}

Tester\Environment::setup();

\Tester\Helpers::purge(__DIR__ . '/temp');

//Nette\Diagnostics\Debugger::enable(FALSE, __DIR__ . '/temp');

$configurator = new Nette\Configurator;
$configurator->setDebugMode(FALSE);
$configurator->setTempDirectory(__DIR__ . '/temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/../src')
	->register();

$configurator->addConfig(__DIR__ . '/config.neon');
return $configurator->createContainer();