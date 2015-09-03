<?php

namespace JedenWeb\Newsletter\DI;

use JedenWeb;
use Nette;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
class NewsletterExtension extends Nette\DI\CompilerExtension
{

	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();

		$container->addDefinition($this->prefix('dispatcher'))
			->setClass('JedenWeb\Newsletter\SubscriptionDispatcher');

		$container->addDefinition($this->prefix('newsletterForm'))
			->setImplement('JedenWeb\Newsletter\INewsletterForm');
	}

}
