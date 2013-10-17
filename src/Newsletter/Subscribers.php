<?php

namespace JedenWeb\Newsletter;

use JedenWeb;
use Nette;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
class Subscribers extends \App\Model\Table
{
	
	const PENDING = -1;
	
	const UNSUBSCRIBED = 0;

	const SUBSCRIBED = 1;
	
	const BLOCKED = 2;
	
	/** @var string */
	protected $tableName = 'newsletter';
	
	
	
	/**
	 * @return Nette\Database\Table\Selection
	 */
	public function findSubscribed()
	{
		return $this->findBy(array(
			'status' => self::SUBSCRIBED,
		));
	}
	
	
	/**
	 * @return Nette\Database\Table\Selection
	 */
	public function findUnsubscribed()
	{
		return $this->findBy(array(
			'status' => self::UNSUBSCRIBED,
		));
	}
	
	
	
	/**
	 * @param string $email
	 * @return Nette\Database\Table\ActiveRow|FALSE
	 */
	public function findSubscribedByEmail($email)
	{
		return $this->findOneBy(array(
			'email' => $email,
            'status' => self::SUBSCRIBED,
			'unsubscribedAt IS NULL'
		));
	}
	
	
	/**
	 * @param string $email
	 * @return Nette\Database\Table\ActiveRow|FALSE
	 */
	public function findUnsubscribedByEmail($email)
	{
		return $this->findOneBy(array(
			'email' => $email,
            'status' => self::UNSUBSCRIBED,
			'unsubscribedAt IS NOT NULL'
		));
	}
	
	
	/**
	 * @param string $email
	 * @return Nette\Database\Table\ActiveRow|FALSE
	 */
	public function findPendingByEmail($email)
	{
		return $this->findOneBy(array(
			'email' => $email,
            'status' => self::PENDING
		));
	}
	
	
	/**
	 * @param string $email
	 * @return Nette\Database\Table\ActiveRow|FALSE
	 */
	public function findOneByEmail($email)
	{
		return $this->findBy(array(
			'email' => $email,
		))->order('id DESC')->limit(1)->fetch();
	}
	
	
	
	/**
	 * @param array $values
	 */
	public function addSubscriber($values)
	{		
		$this->createRow(array(
			'email' => $values['email'],
			'subscribe_code' => \JedenWeb\Utils\Strings::random(20),
			'subscribedAt' => new \Nette\DateTime,
		));
	}
	
}
