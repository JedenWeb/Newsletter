<?php

namespace JedenWeb\Newsletter\DI;

use JedenWeb;
use Nette;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 * @todo Add unsubscribe to confirm mail and set status to BLOCKED
 */
class NewsletterExtension extends Nette\DI\CompilerExtension
{
	
	/** @var array */
	private $defaults = array(
		'confirmSubscribe' => TRUE,
		'subscribe' => array(
			'from' => NULL,
			'subject' => NULL,
			'requestTimeout' => 60,
		),
	);
	
	
	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$container = $this->getContainerBuilder();
		
		
		if ($config['confirmSubscribe']) {
			if (!array_key_exists('from', $config['subscribe'])) {
				throw new Nette\InvalidArgumentException("Item 'from' must be declared in '". $this->name .":subscribe' section.");
			}
			
			if (!Nette\Utils\Validators::isEmail($config['subscribe']['from'])) {
				throw new Nette\InvalidArgumentException("Item 'from' must be valid email address.");
			}
		}
		
		$container->addDefinition($this->prefix('subscribers'))
			->setClass('JedenWeb\Newsletter\Subscribers');
		
		$container->addDefinition($this->prefix('newsletterForm'))
			->setImplement('JedenWeb\Newsletter\INewsletterForm');
		
		$container->addDefinition($this->prefix('newsletterListener'))
			->setClass('JedenWeb\Newsletter\NewsletterListener')
			->addSetup('$confirmSubscribe', array($config['confirmSubscribe']))
			->addSetup('$subscription', array($config['subscribe']))
			->addTag('kdyby.subscriber');
	}
	
}
