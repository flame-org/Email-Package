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
	 * @return \Nette\Templating\FileTemplate
	 */
	public function getTemplate();

	/**
	 * @param string $path
	 * @return $this
	 */
	public function setTemplateFile($path);

	/**
	 * @param Message $message
	 * @return void
	 */
	public function send(Message $message);
}