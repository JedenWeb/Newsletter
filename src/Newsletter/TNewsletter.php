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
	 * @inject
	 * @var JedenWeb\Newsletter\Subscribers
	 */
	public $subscribers;
	
	
	
	/**
	 * @param string $code
	 */
	public function actionSubscribe($code)
	{
		if ($code) {
			if ($subscriber = $this->subscribers->findOneBy(array('subscribe_code' => $code))) {
				$subscriber->update(array(
					'subscribed_ip' => $this->getHttpRequest()->getRemoteAddress(),
					'subscribe_code' => NULL,
					'unsubscribe_code' => \JedenWeb\Utils\Strings::random(20),
					'status' => Subscribers::SUBSCRIBED,
				));
			}
		}
	
		$this->redirect('default');
	}


    /**
     * @param string $code
     */
    public function actionUnsubscribe($code)
    {
        if ($code) {
            if ($subscriber = $this->subscribers->findOneBy(array('unsubscribe_code' => $code))) {
                $subscriber->update(array(
                    'unsubscribe_code' => NULL,
                    'unsubscribed_ip' => $this->getHttpRequest()->getRemoteAddress(),
                    'unsubscribedAt' => new Nette\DateTime,
					'status' => Subscribers::UNSUBSCRIBED,
                ));
            }
        }

        $this->redirect('default');
    }
	
	
	
	/**
	 * @param string $name
	 * @return \JedenWeb\Newsletter\NewsletterForm
	 */
	protected function createComponentNewsletterForm($name)
	{
		return $this->newsletterFormFactory->create();
	}

}
