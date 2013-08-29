<?php
/**
 * Class EmailFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 29.08.13
 */
namespace Flame\Email;

use Nette\Application\Application;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Object;

class EmailFactory extends Object
{

	/** @var \Nette\Application\Application  */
	private $application;

	/** @var \Nette\Mail\IMailer  */
	private $mailer;

	/**
	 * @param Application $application
	 * @param IMailer $mailer
	 */
	function __construct(Application $application, IMailer $mailer)
	{
		$this->application = $application;
		$this->mailer = $mailer;
	}

	/**
	 * @return Email
	 */
	public function createEmail()
	{
		return new Email($this->mailer, $this->application->getPresenter());
	}

}