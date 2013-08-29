Email Package
=================

Advanced emails with custom templates on Nette

##Exmaple of usage
```php
use Enlan\UserModule\Entity\User;
use Flame\Email\EmailAddress;
use Flame\Email\IEmailFactory;
use Flame\Email\IFullMessageFactory;
use Flame\Types\Password;
use Nette\Object;

class NewUserEmail extends Object implements INewUserEmail
{

	/** @var  IEmailFactory */
	private $emailFactory;

	/** @var  IFullMessageFactory */
	private $messageFactory;

	/**
	 * @param IEmailFactory $emailFactory
	 * @param IFullMessageFactory $messageFactory
	 */
	function __construct(IEmailFactory $emailFactory, IFullMessageFactory $messageFactory)
	{
		$this->emailFactory = $emailFactory;
		$this->messageFactory = $messageFactory;
	}

	/**
	 * @param User $user
	 */
	public function send(User $user)
	{
		$message = $this->messageFactory
			->addTo(new EmailAddress($user->getEmail(), $user->getIdentifier()))
			->setFrom('support')
			->createMessage()
			->setSubject('Hello');

		$email = $this->emailFactory
			->createEmail()
			->setTemplateFile(__DIR__ . '/../templates/NewUserEmail.latte');

		$email->template->greeting = 'Hi, all!';
		$email->send($message);
	}
}
```