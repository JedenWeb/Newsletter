<?php

namespace JedenWeb\Newsletter;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
abstract class Subscriber extends \Nette\Object implements \Kdyby\Events\Subscriber
{

	/**
	 * @param string
	 */
	abstract public function subscribe($email);
	
	
	/**
	 * @param string
	 */
	abstract public function unsubscribe($email);
	
	
	/**
	 * @return array
	 */
	final public function getSubscribedEvents()
	{
		return array(
			'JedenWeb\Newsletter\SubscriptionDispatcher::onSubscribe' => 'subscribe',
			'JedenWeb\Newsletter\SubscriptionDispatcher::onUnsubscribe' => 'unsubscribe',
		);
	}

}
