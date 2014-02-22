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
use Nette\InvalidStateException;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Object;
use Nette\Templating\FileTemplate;

/**
 * Class Email
 *
 * @package Flame\Email
 * @property-read \Nette\Templating\ITemplate $template
 */
class Email extends Object implements IEmail
{

	/** @var \Nette\Application\UI\Presenter  */
	private $presenter;

	/** @var  IMailer */
	private $mailer;

	/** @var  string */
	private $templateFile;

	/** @var  \Nette\Templating\FileTemplate */
	private $template;

	/** @var Message  */
	private $message;

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
	 * @throws \Nette\InvalidStateException
	 */
	public function send()
	{
		if ($this->message === null) {
			throw new InvalidStateException('Please set Message with ' . __CLASS__ . '::' . 'setMessage()');
		}

		if($this->templateFile !== null) {
			$this->message->setHtmlBody($this->getTemplate());
		}

		$this->mailer->send($this->message);
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
		$template->registerFilter($this->getDICLatte());

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

	/**
	 * @return \Nette\Templating\FileTemplate
	 */
	public function getTemplate()
	{
		if($this->template === null) {
			$this->template = $this->createTemplate();
		}

		return $this->template;
	}

	/**
	 * @param Message $message
	 * @return $this
	 */
	public function setMessage(Message $message)
	{
		$this->message = $message;
		return $this;
	}

	/**
	 * @return Message
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * @return \Nette\Latte\Engine
	 */
	private function getDICLatte()
	{
		$method = $this->presenter->getContext()->getMethodName('nette.latte', false);
		return $this->presenter->getContext()->$method();
	}
}