<?php
/**
 * Class Address
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.04.13
 */

namespace Flame\Email;

use Nette\Object;

class EmailAddress extends Object implements IEmailAddress
{

	/** @var string  */
	private $email;

	/** @var string  */
	private $name;

	/**
	 * @param $email
	 * @param string $name
	 */
	public function __construct($email, $name = '')
	{
		$this->email = (string) $email;
		$this->name = (string) $name;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->getEmail();
	}
}