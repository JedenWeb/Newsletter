<?php

namespace JedenWeb\Newsletter;

use Nette;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
class NewsletterForm extends Nette\Application\UI\Form
{
	
	/** @var SubscriptionDispatcher */
	private $dispatcher;
	
	
	/**
	 * @param SubscriptionDispatcher
	 */
	public function __construct(SubscriptionDispatcher $dispatcher)
	{
		parent::__construct();
		
		$this->dispatcher = $dispatcher;
	}
	
	
	/**
	 * @param Nette\Application\IPresenter
	 */
	protected function attached($presenter)
	{
		parent::attached($presenter);
		
		if ($presenter instanceof Nette\Application\IPresenter) {
			$this->beforeSetup();
			$this->setup();
		}
	}

	
	protected function beforeSetup()
	{		
		$this->getElementPrototype()->novalidate = 'novalidate';
	}
	

	public function setup()
	{
		$this->addText('email', 'Váš e-mail:')
			->setType('email')
			->addRule(self::EMAIL, '%value se nezdá být správný email, zkontrolujte jej, prosím.')
			->setRequired('Zadejte svůj email, prosím.')
			->setEmptyValue('@');

		$this->addSubmit('submit', 'Odeslat');
		
		$that = $this;
		$this->onSuccess[] = $this->handleSuccess;
	}
	
	
	public function handleSuccess()
	{
		$email = $this->values->email;
		$this->dispatcher->subscribe($email);
	}

}


/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
interface INewsletterForm
{

	/** @return NewsletterForm */
	public function create();
	
}
