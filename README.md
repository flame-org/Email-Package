Email Package
=================

Advanced emails with custom templates on Nette

###Instalation
**Install the package via composer.**
Add into your dependencies: `"flame/email-package": ">=2.0.0"`

**Register emails extension**
```php
	\Flame\Email\DI\EmailsExtension::register($configurator);
```

**Configure emails via config**
```yml
	emails:
        support: [sifalda.jiri@gmail.com, Support]
```
From this configuration will be created object of **Flame\Email\EmailAddress** which will be added into **Flame\Email\EmailAddressContainer**.

##Example of usage
**Create custom email**
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

**Template file**
```smarty
	<h3>Greeting</h3>
	<p>{$greeting}</p>
	<a href="{plink Homepage: }" target="_blank">Visit homepage</a>

```

**Mailer**
```php

	use Enlan\UserModule\Entity\User;
    use Nette\Object;

    class Mailer extends Object implements IMailer
    {

    	/** @var \Enlan\UserModule\Emails\INewUserEmail  */
    	private $newUserEmail;

    	/**
    	 * @param INewUserEmail $newUserEmail
    	 */
    	function __construct(INewUserEmail $newUserEmail)
    	{
    		$this->newUserEmail = $newUserEmail;
    	}

    	/**
    	 * @param User $user
    	 */
    	public function sendEmailsOnCreate(User $user)
    	{
    		$this->newUserEmail->send($user);
    	}

    }

```

**Now, you can use Mailer for sending your advanced Nette emails :-)**