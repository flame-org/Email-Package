<?php
/**
 * Class Email
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 29.08.13
 */
namespace Flame\Email;

use Nette\Application\UI\Presenter;
use Nette\InvalidArgumentException;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Object;
use Nette\Templating\FileTemplate;

class Email extends Object implements IEmail
{

	/** @var \Nette\Application\UI\Presenter  */
	private $presenter;

	/** @var  IMailer */
	private $mailer;

	/** @var  string */
	private $templateFile;

	/**
	 * @param IMailer $mailer
	 * @param Presenter $presenter
	 */
	function __construct(IMailer $mailer, Presenter $presenter)
	{
		$this->mailer = $mailer;
		$this->presenter = $presenter;
	}

	/**
	 * @param Message $message
	 */
	public function send(Message $message)
	{
		if($this->templateFile !== null) {
			$message->setHtmlBody($this->createTemplate());
		}

		$this->mailer->send($message);
	}

	/**
	 * @param string $path
	 * @return $this
	 * @throws \Nette\InvalidArgumentException
	 */
	public function setTemplateFile($path)
	{
		$this->templateFile = (string) $path;
		if(!file_exists($this->templateFile)) {
			throw new InvalidArgumentException('Template file "' . $this->templateFile . '" not found.');
		}
		return $this;
	}

	/**
	 * @return FileTemplate
	 */
	protected function createTemplate()
	{
		$template = new FileTemplate($this->templateFile);
		$template->registerHelperLoader('Nette\Templating\Helpers::loader');

		// default parameters
		$template->presenter = $template->_presenter = $this->presenter;
		$template->setCacheStorage($this->presenter->getContext()->getService('nette.templateCacheStorage'));
		$template->user = $this->presenter->getUser();
		$template->netteHttpResponse = $this->presenter->getContext()->getByType('Nette\Http\Response');
		$template->netteCacheStorage = $this->presenter->getContext()->getByType('Nette\Caching\IStorage');
		$template->baseUri = $template->baseUrl = rtrim($this->presenter->getContext()->getByType('Nette\Http\Request')->getUrl()->getBaseUrl(), '/');
		$template->basePath = preg_replace('#https?://[^/]+#A', '', $template->baseUrl);

		return $template;
	}
}