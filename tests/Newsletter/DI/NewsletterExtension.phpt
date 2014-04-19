<?php

namespace Test;

use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/../../bootstrap.php';


class NewsletterExtensionTest extends Tester\TestCase
{
	
	/** @var Nette\DI\Container */
	private $container;


	/**
	 * @param Nette\DI\Container $container
	 */
	public function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}


	public function testCompiled()
	{
		Assert::type('JedenWeb\Newsletter\SubscriptionDispatcher', $this->container->getService('newsletter.dispatcher'));
		Assert::type('JedenWeb\Newsletter\INewsletterForm', $this->container->getService('newsletter.newsletterForm'));
	}

}


$test = new NewsletterExtensionTest($container);
$test->run();
