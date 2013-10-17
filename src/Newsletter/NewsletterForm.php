<?php

namespace JedenWeb\Newsletter;

use JedenWeb;
use Nette;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
class NewsletterForm extends JedenWeb\Application\UI\Form
{
	
	/** 
	 * @var array
	 */
	public $onSuccess = array();
	
	/**
	 * @var Subscribers
	 */
	private $subscribers;

	/**
	 * @var \Nette\Http\Request
	 */
	public $httpRequest;
	
	
	
	/**
	 * @param \JedenWeb\Newsletter\Subscribers $subscribers
	 * @param \Nette\Http\Request $httpRequest
	 */
	public function __construct(Subscribers $subscribers, \Nette\Http\Request $httpRequest)
	{
		parent::__construct();
		
		$this->subscribers = $subscribers;
		$this->httpRequest = $httpRequest;
	}

	
	protected function beforeSetup()
	{		
		$this->getElementPrototype()->novalidate = 'novalidate';
		
		\Nette\Forms\Rules::$defaultMessages[self::EMAIL] = 'Formát zadaného emailu není správný. Zkontroluj jej.';
	}
	

	public function setup()
	{
//		$this->addEmail('email', 'Tvůj email:')
		$this->addText('email', 'Tvůj email:')
			->setType('email')
			->setRequired('Vyplň, prosím, tvůj email.')
			->setEmptyValue('@');

		$this->addSubmit('submit', 'Odeslat');
	}


	public function handleSuccess()
	{
		$values = $this->getValues();
		
		$subscriber = $this->subscribers->findOneByEmail($values->email);
		
		if ($subscriber && $subscriber->status !== Subscribers::UNSUBSCRIBED) {
			
			$this->presenter->flashMessage('Tvůj e-mail již máme, díky!');
			
		} else {
			
			$this->subscribers->addSubscriber(array(
				'email' => $values->email,
			));
	
			$this->presenter->flashMessage('Byl jsi úspěšně přihlášen k newsletteru. Děkujeme!');

		}
	}

}
