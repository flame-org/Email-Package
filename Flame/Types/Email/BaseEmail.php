<?php
/**
 * Class BaseEmail
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 25.04.13
 */
namespace Flame\Types\Email;

use Flame\Caching\CacheProvider;
use Flame\Types\Email\Address\AddressProvider;
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

	/** @var \Flame\Types\Email\Address\AddressProvider  */
	private $addressProvider;

	/**
	 * @param IMailer $mailer
	 * @param AddressProvider $addressProvider
	 */
	public function __construct(IMailer $mailer, AddressProvider $addressProvider)
	{
		$this->mailer = $mailer;
		$this->addressProvider = $addressProvider;
	}

	/**
	 * @return AddressProvider
	 */
	public function getAddressProvider()
	{
		return $this->addressProvider;
	}

	/**
	 * @return IMailer
	 */
	public function getMailer()
	{
		return $this->mailer;
	}

	/**
	 * @return bool|void
	 */
	public function send()
	{
		$message = $this->getEmailMessage()
			->setHtmlBody($this->getFileTemplate());
		return $this->getMailer()->send($message);
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