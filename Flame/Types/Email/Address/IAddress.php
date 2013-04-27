<?php
/**
 * Class IAddress
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.04.13
 */

namespace Flame\Types\Email\Address;

interface IAddress
{

	/**
	 * @return string
	 */
	public function getEmail();

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return mixed
	 */
	public function getData();

	/**
	 * @return string
	 */
	public function getIdentifier();

}