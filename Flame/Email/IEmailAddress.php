<?php
/**
 * Class IAddress
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.04.13
 */

namespace Flame\Email;

interface IEmailAddress
{

	/**
	 * @return string
	 */
	public function getEmail();

	/**
	 * @return string
	 */
	public function getName();

}