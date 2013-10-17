<?php

namespace JedenWeb\Newsletter;

use JedenWeb;
use Nette;
use Nette\Application\Application;
use Nette\Mail\IMailer;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
class NewsletterListener extends Nette\Object implements \Kdyby\Events\Subscriber
{
	
	/**
	 * @var bool
	 */
	private $confirmSubscribe;
	
	/**
	 * @var array
	 */
	private $subscription;
	
	/**
	 * @var Application
	 */
	private $application;
	
	/**
	 * @var Subscribers
	 */
	private $subscribers;

	/**
	 * @var Nette\Mail\IMailer
	 */
	private $mailer;
	
	
	
	/**
	 * @param \Nette\Application\Application $application
	 * @param \Components\Newsletter\Subscribers $subscribers
	 * @param \Nette\Mail\IMailer $mailer
	 */
	public function __construct(
		Application $application,
		Subscribers $subscribers,
		IMailer $mailer
	) {
		$this->application = $application;
		$this->subscribers = $subscribers;
		$this->mailer = $mailer;
	}
	
	
	
	/**
	 * @param \Components\Newsletter\NewsletterForm $form
	 */
	public function onSuccess(NewsletterForm $form)
	{
		$values = $form->getValues();
		
		$subscriber = $this->subscribers->findPendingByEmail($values->email);
		
		if ($this->confirmSubscribe && $subscriber) {
			
			if (
				$subscriber->requestedAt && 
				time() - $subscriber->requestedAt->getTimestamp() < $this->subscription['requestTimeout']
			) {
				return;
			}
			
			
			/* @var \Nette\Templating\FileTemplate $template */
			$template = clone $this->application->presenter->getTemplate();
			$template->setFile(__DIR__ . '/confirm.latte');
			$template->code = $subscriber->subscribe_code;
			
			// send mail
			$message = new \Nette\Mail\Message;
			$message->setFrom($this->subscription['from'])
					->setSubject($this->subscription['subject'])
					->addTo($values->email)
					->setHtmlBody($template);
			
			$this->mailer->send($message);
			
			$subscriber->update(array(
				'requestedAt' => new Nette\DateTime,
				'requestCount' => $subscriber->requestCount + 1
			));

		}
	}
	
	
	
	public function getSubscribedEvents()
	{
		return array('JedenWeb\Newsletter\NewsletterForm::onSuccess');
	}
	
	
	
	/**
	 * @param bool $value
	 */
	public function setConfirmSubscribe($value)
	{
		$this->confirmSubscribe = (bool) $value;
	}
	
	
	/**
	 * @param array $settings
	 */
	public function setSubscription(array $settings)
	{
		$this->subscription = $settings;
	}
	
}
