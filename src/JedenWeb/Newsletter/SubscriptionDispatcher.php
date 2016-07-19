<?php

namespace JedenWeb\Newsletter;

/**
 * @method void onSubscribe($email)
 * @method void onUnsubscribe($email)
 *
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
class SubscriptionDispatcher extends \Nette\Object
{
	
	/** @var array */
	public $onSubscribe;
	
	/** @var array */
	public $onUnsubscribe;
	
	
	/**
	 * @param string
	 */
	public function subscribe($email)
	{
		$this->validateEmail($email);
		$this->onSubscribe($email);
	}
	
	
	/**
	 * @param string
	 */
	public function unsubscribe($email)
	{
		$this->validateEmail($email);
		$this->onUnsubscribe($email);
	}
	
	
	/**
	 * @param string
	 * @throws \Nette\InvalidArgumentException
	 */
	private function validateEmail($email)
	{
		if (!\Nette\Utils\Validators::isEmail($email)) {
			throw new \Nette\InvalidArgumentException;
		}
	}
	
}
