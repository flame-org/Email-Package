<?php
/**
 * Class IEmailFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 29.08.13
 */
namespace Flame\Email;

interface IEmailFactory
{

	/**
	 * @return Email
	 */
	public function createEmail();
}