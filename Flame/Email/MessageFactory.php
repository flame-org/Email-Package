<?php
/**
 * Class MessageFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 29.08.13
 */
namespace Flame\Email;

use Nette\InvalidArgumentException;
use Nette\Mail\Message;
use Nette\Object;
use Nette\Utils\Validators;

class MessageFactory extends Object implements IFullMessageFactory
{

	/** @var \Nette\Mail\Message  */
	private $message;

	/** @var \Flame\Email\EmailAddressContainer  */
	private $addressContainer;

	/**
	 * @param EmailAddressContainer $addressContainer
	 */
	function __construct(EmailAddressContainer $addressContainer)
	{
		$this->addressContainer = $addressContainer;
		$this->message = new Message;
	}

	/**
	 * @return Message
	 */
	public function createMessage()
	{
		return $this->message;
	}

	/**
	 * @param string|EmailAddress $from
	 * @return $this
	 */
	public function setFrom($from)
	{
		$email = $this->getEmailAddress($from);

		if($email instanceof EmailAddress) {
			$this->message->setFrom($email->getEmail(), $email->getName());
		}else{
			$this->message->setFrom($email);
		}

		return $this;
	}

	/**
	 * @param string|EmailAddress $to
	 * @return $this
	 */
	public function addReplyTo($to)
	{
		$email = $this->getEmailAddress($to);
		if($email instanceof EmailAddress) {
			$this->message->addReplyTo($email->getEmail(), $email->getName());
		}else{
			$this->message->addReplyTo($email);
		}

		return $this;
	}

	/**
	 * @param string|EmailAddress $to
	 * @return $this
	 */
	public function addTo($to)
	{
		$email = $this->getEmailAddress($to);
		if($email instanceof EmailAddress) {
			$this->message->addTo($email->getEmail(), $email->getName());
		}else{
			$this->message->addTo($email);
		}

		return $this;
	}

	/**
	 * @param $input
	 * @return EmailAddress|string
	 * @throws \Nette\InvalidArgumentException
	 */
	private function getEmailAddress($input)
	{
		if(!$input instanceof EmailAddress && !is_string($input)) {
			throw new InvalidArgumentException('Invalid email address given. Must be string or instance of Flame\Email\EmailAddress');
		}

		if(is_string($input)) {
			if(!Validators::isEmail($input)) {
				$input = $this->addressContainer->getAddress($input);
			}
		}

		return $input;
	}
}