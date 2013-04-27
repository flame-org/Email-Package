<?php
/**
 * Class IAdressFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.04.13
 */

namespace Flame\Types\Email\Address;

interface IAdressFactory
{

	/**
	 * @return IAddress
	 */
	public function create();

}