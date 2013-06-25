<?php
/**
 * Class CachedEmail
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 25.04.13
 */
namespace Flame\Email;

use Flame\Email\Address\AddressProvider;
use Nette\Caching\IStorage;
use Nette\Mail\IMailer;

abstract class CachedEmail extends BaseEmail
{

	/** @var \Nette\Caching\IStorage  */
	private $storage;

	/**
	 * @param IMailer $mailer
	 * @param AddressProvider $addressProvider
	 * @param IStorage $storage
	 */
	public function __construct(IMailer $mailer, AddressProvider $addressProvider, IStorage $storage)
	{
		parent::__construct($mailer, $addressProvider);
		$this->storage = $storage;
	}

	/**
	 * @param string $templateFile
	 * @return \Nette\Templating\FileTemplate
	 */
	protected function createFileTemplate($templateFile = '')
	{
		$fileTemplate = parent::createFileTemplate($templateFile);
		$fileTemplate->setCacheStorage($this->storage);
		return $fileTemplate;
	}

}