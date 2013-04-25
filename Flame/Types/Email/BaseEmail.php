<?php
/**
 * Class BaseEmail
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 25.04.13
 */
namespace Flame\Types\Email;

use Flame\Caching\CacheProvider;
use Nette\Callback;
use Nette\Latte\Engine;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Object;
use Nette\Templating\FileTemplate;

abstract class BaseEmail extends Object implements IEmail
{

	/** @var \Nette\Mail\IMailer  */
	private $mailer;

	/**
	 * @param IMailer $mailer
	 */
	public function __construct(IMailer $mailer)
	{
		$this->mailer = $mailer;
	}

	/**
	 * @return IMailer
	 */
	public function getMailer()
	{
		return $this->mailer;
	}

	/**
	 * @param string $templatePath
	 * @return FileTemplate
	 */
	protected function createFileTemplate($templatePath = '')
	{
		$fileTemplate = new FileTemplate($templatePath);
		$fileTemplate->registerFilter(Callback::create(new Engine));
		$fileTemplate->registerHelperLoader('Nette\Templating\Helpers::loader');
		$fileTemplate->registerHelperLoader('Flame\Templating\Helpers::loader');
		return $fileTemplate;
	}

	/**
	 * @return Message
	 */
	protected function createMessage()
	{
		return new Message;
	}

}