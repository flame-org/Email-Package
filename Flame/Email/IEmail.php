<?php
/**
 * Class IEmail
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 25.04.13
 */
namespace Flame\Email;

use Nette\Mail\Message;

interface IEmail
{

	/**
	 * @param Message $message
	 * @return $this
	 */
	public function setMessage(Message $message);

	/**
	 * @return Message
	 */
	public function getMessage();

	/**
	 * @return \Nette\Templating\FileTemplate
	 */
	public function getTemplate();

	/**
	 * @param string $path
	 * @return $this
	 */
	public function setTemplateFile($path);

	/**
	 * @return void
	 */
	public function send();
}