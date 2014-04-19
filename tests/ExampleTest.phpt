<?php

namespace Test;

use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';


class ExampleTest extends Tester\TestCase
{
	
	/** @var Nette\DI\Container */
	private $container;


	/**
	 * @param Nette\DI\Container $container
	 */
	function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}


	function setUp()
	{
	}


	function testSomething()
	{
		Assert::true( true );
	}

}


$test = new ExampleTest($container);
$test->run();
