<?php
/**
 * Class BaseEmail
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 25.04.13
 */
namespace Flame\Email;

use Flame\Caching\CacheProvider;
use Flame\Email\Address\AddressProvider;
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

	/** @var \Flame\Email\Address\AddressProvider  */
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
	 * @param $key
	 * @return Address\IAddress
	 */
	public function getEmailAddress($key)
	{
		return $this->addressProvider->getEmail($key);
	}

	/**
	 * @return void
	 */
	public function send()
	{
		$message = $this->getEmailMessage()
			->setHtmlBody($this->getFileTemplate());
		$this->mailer->send($message);
	}

	/**
	 * @param string $templatePath
	 * @return FileTemplate
	 */
	protected function createFileTemplate($templatePath = null)
	{
		if($templatePath === null) {
			$templatePath = $this->getTemplateName();
		}
		
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

	/**
	 * @return string
	 */
	protected function getTemplateName()
	{
		return $this->getReflection()->getShortName() . '.latte';
	}

}