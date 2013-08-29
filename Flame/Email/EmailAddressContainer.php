<?php
/**
 * Class AddressContainer
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 29.08.13
 */
namespace Flame\Email;

use Nette\InvalidArgumentException;
use Nette\InvalidStateException;
use Nette\Object;
use Nette\Utils\Validators;

class EmailAddressContainer extends Object
{

	/** @var array  */
	private $addresses = array();

	/**
	 * @param array $addresses
	 */
	function __construct(array $addresses = array())
	{
		if(count($addresses)) {
			foreach ($addresses as $id => $address) {
				$this->addAddress($id, $address);
			}
		}
	}

	/**
	 * @param string $identifier
	 * @param IEmailAddress $address
	 * @return $this
	 * @throws \Nette\InvalidStateException
	 * @throws \Nette\InvalidArgumentException
	 */
	public function addAddress($identifier, $address)
	{
		if(isset($this->addresses[$identifier])) {
			throw new InvalidStateException('Email address with same identifier "' . $identifier . '" already exist.');
		}

		if(Validators::isEmail($identifier)) {
			throw new InvalidArgumentException('Identifier cannot be email address');
		}

		if(!$address instanceof IEmailAddress) {
			if(!is_array($address) || !isset($address[0])) {
				throw new InvalidArgumentException('Address configuration must be array or instance of Flame\Email\IEmailAddress');
			}

			$address = new EmailAddress($address[0], (isset($address[1])) ? $address[1] : null);
		}

		$this->addresses[$identifier] = $address;
		return $this;
	}

	/**
	 * @param $identifier
	 * @return mixed
	 * @throws \Nette\InvalidStateException
	 */
	public function getAddress($identifier)
	{
		if(isset($this->addresses[$identifier])) {
			return $this->addresses[$identifier];
		}

		throw new InvalidStateException('Email address with identifier "' . $identifier . '" not found.');
	}

	/**
	 * @return array
	 */
	public function getAddresses()
	{
		return $this->addresses;
	}
}