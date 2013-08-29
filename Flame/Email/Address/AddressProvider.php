<?php
/**
 * Class AddressProvider
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.04.13
 */

namespace Flame\Email\Address;

use Nette\InvalidArgumentException;
use Nette\Object;

class AddressProvider extends Object
{

	/** @var \Flame\Email\Address\IAdressFactory  */
	private $addressFactory;

	/** @var array  */
	private $emails = array();

	/**
	 * @param array $emails
	 * @param IAdressFactory $addressFactory
	 */
	public function __construct(array $emails, IAdressFactory $addressFactory)
	{
		$this->emails = $emails;
		$this->addressFactory = $addressFactory;
	}

	/**
	 * @return array
	 */
	public function getRawEmails()
	{
		return $this->emails;
	}

	/**
	 * @param $key
	 * @return IAddress
	 * @throws \Nette\InvalidArgumentException
	 */
	public function getEmail($key)
	{
		$email = $this->get($key);

		if($email === null) {
			throw new InvalidArgumentException('Email with key "' . $key . '" does not exist');
		}

		return $this->addressFactory->create($key, $email);
	}

	/**
	 * @param null $name
	 * @return array|null
	 */
	public function get($name)
	{
		return (isset($this->emails[$name])) ? $this->emails[$name] : null;
	}

	/**
	 * @param $name
	 * @param $value
	 * @throws \Nette\InvalidArgumentException
	 */
	public function set($name, $value)
	{
		if(isset($this->emails[$name]))
			throw new InvalidArgumentException('Email with key "' . $name . '" is set yet!');

		$this->emails[$name] = $value;
	}
}