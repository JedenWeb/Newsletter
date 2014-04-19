<?php

namespace JedenWeb\Newsletter;

use JedenWeb;
use Nette;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
trait TNewsletter
{
	
	/** 
	 * @inject
	 * @var JedenWeb\Newsletter\INewsletterForm
	 */
	public $newsletterFormFactory;
	
	
	/**
	 * @param string $name
	 * @return \JedenWeb\Newsletter\NewsletterForm
	 */
	protected function createComponentNewsletterForm($name)
	{
		return $this->newsletterFormFactory->create();
	}

}
