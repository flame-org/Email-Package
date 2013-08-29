<?php
/**
 * Class IMessageFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 29.08.13
 */
namespace Flame\Email;

interface IMessageFactory
{

	/**
	 * @return \Nette\Mail\Message
	 */
	public function createMessage();
}