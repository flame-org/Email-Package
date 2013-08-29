<?php
/**
 * Class AddressFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.04.13
 */

namespace Flame\Email\Address;

use Nette\Object;
use Nette\Reflection\ClassType;

class AddressFactory extends Object implements IAdressFactory
{

	const ADDRESS_CLASS = '\Flame\Email\Address\Address';

	/**
	 * @return Address
	 */
	public function create()
	{
		$reflection = ClassType::from(self::ADDRESS_CLASS);
		return $reflection->newInstanceArgs(func_get_args());
	}
}