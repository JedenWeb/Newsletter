<?php

namespace Test;

use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';


class SubscriptionDispatcherTest extends Tester\TestCase
{
	
	/** @var \JedenWeb\Newsletter\SubscriptionDispatcher */
	private $dispatcher;
	
	/** @var Nette\DI\Container */
	private $container;


	/**
	 * @param Nette\DI\Container $container
	 */
	public function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}
	
	
	public function setUp()
	{
		$this->dispatcher = $this->container->getByType('JedenWeb\Newsletter\SubscriptionDispatcher');
	}
	
	
	/**
	 * @throws \Nette\InvalidArgumentException
	 */
	public function testInvalidEmail()
	{
		$this->dispatcher->subscribe('invalid email');
	}


	public function testSubscribe()
	{
		$subscribed = FALSE;
		$this->dispatcher->onSubscribe[] = function() use (&$subscribed) {
			$subscribed = TRUE;
		};
		
		$this->dispatcher->subscribe('email@example.com');
		
		Assert::true($subscribed);
	}


	public function testUnsubscribe()
	{
		$unsubscribed = FALSE;
		$this->dispatcher->onUnsubscribe[] = function() use (&$unsubscribed) {
			$unsubscribed = TRUE;
		};
		
		$this->dispatcher->unsubscribe('email@example.com');
		
		Assert::true($unsubscribed);
	}

}


$test = new SubscriptionDispatcherTest($container);
$test->run();
