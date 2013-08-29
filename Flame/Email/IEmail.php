<?php
/**
 * Class IEmail
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 25.04.13
 */
namespace Flame\Email;

interface IEmail
{

	/**
	 * @return \Nette\Templating\FileTemplate
	 */
	public function getFileTemplate();

	/**
	 * @return \Nette\Mail\Message
	 */
	public function getEmailMessage();

	/**
	 * @return \Nette\Mail\IMailer
	 */
	public function getMailer();

	/**
	 * @return void
	 */
	public function send();

}