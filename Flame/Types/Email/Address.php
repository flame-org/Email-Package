<?php
/**
 * Class Address
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.04.13
 */

namespace Flame\Types\Email;

use Nette\InvalidArgumentException;
use Nette\Object;

class Address extends Object implements IAddress
{

	/** @var  string */
	private $identifier;

	/** @var  mixed */
	private $data;

	/**
	 * @param string $identifier
	 * @param array $data
	 */
	public function __construct($identifier, $data = array())
	{
		$this->identifier = (string) $identifier;
		$this->data = $data;
	}

	/**
	 * @return string
	 * @throws \Nette\InvalidArgumentException
	 */
	public function getEmail()
	{
		if(is_string($this->data)){
			return $this->data;
		}elseif(is_array($this->data) && isset($this->data[0])){
			return (string) $this->data[0];
		}else{
			throw new InvalidArgumentException('Invalid email format');
		}
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return (isset($this->data[1]) ? $this->data[1] : '');
	}

	/**
	 * @return array|mixed
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @return string
	 */
	public function getIdentifier()
	{
		return $this->identifier;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->getEmail();
	}
}