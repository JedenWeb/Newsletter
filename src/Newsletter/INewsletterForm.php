<?php

namespace JedenWeb\Newsletter;

use JedenWeb;
use Nette;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
interface INewsletterForm
{
	
	/** @return \JedenWeb\Newsletter\NewsletterForm */
	public function create();
	
}
