<?php
/**
 * Class CachedEmail
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 25.04.13
 */
namespace Flame\Types\Email;

use Nette\Caching\Cache;

abstract class CachedEmail extends BaseEmail
{

	/** @var \Nette\Caching\Cache  */
	private $cache;

	/**
	 * @param IMailer $mailer
	 * @param Cache $cache
	 */
	public function __construct(IMailer $mailer, Cache $cache)
	{
		parent::__construct($mailer);
		$this->cache = $cache;
	}

	/**
	 * @param string $templateFile
	 * @return \Nette\Templating\FileTemplate
	 */
	protected function createFileTemplate($templateFile = '')
	{
		$fileTemplate = parent::createFileTemplate($templateFile);
		$fileTemplate->setCacheStorage($this->cache->getStorage());
		return $fileTemplate;
	}

}