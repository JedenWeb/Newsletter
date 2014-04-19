<?php

namespace Test;

use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';


class NewsletterPresenter extends \Nette\Application\UI\Presenter
{
	use \JedenWeb\Newsletter\TNewsletter;
};


class TNewsletterTest extends Tester\TestCase
{
	
	/** @var \JedenWeb\Newsletter\SubscriptionDispatcher */
	private $presenter;
	
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
		$this->presenter = $this->container
				->createInstance('Test\NewsletterPresenter');
		$this->container->callInjects($this->presenter);
	}


	public function testFactoryInjected()
	{
		Assert::type('JedenWeb\Newsletter\INewsletterForm', $this->presenter->newsletterFormFactory);
	}
	
	
	public function testFormCreated()
	{
		Assert::type('JedenWeb\Newsletter\NewsletterForm', $this->presenter['newsletterForm']);
	}

}


$test = new TNewsletterTest($container);
$test->run();
