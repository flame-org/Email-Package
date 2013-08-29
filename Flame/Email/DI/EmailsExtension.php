<?php
/**
 * Class EmailExtension
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 29.08.13
 */
namespace Flame\Email\DI;

use Nette\DI\CompilerExtension;
use Nette\Configurator;
use Nette\InvalidStateException;
use Nette\Utils\Validators;

class EmailsExtension extends CompilerExtension
{

	/**
	 * @throws \Nette\InvalidStateException
	 */
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();
		Validators::assert($config, 'array');

		$builder->addDefinition($this->prefix('emailFactory'))
			->setClass('Flame\Email\EmailFactory');

		$builder->addDefinition($this->prefix('messageFactory'))
			->setClass('Flame\Email\MessageFactory');

		$addressContainer = $builder->addDefinition($this->prefix('emailAddressContainer'))
			->setClass('Flame\Email\EmailAddressContainer');

		if(count($config)) {
			foreach($config as $id => $address) {
				if(!is_string($id)) {
					throw new InvalidStateException('Please set email address identifier');
				}

				if(!is_array($address)) {
					throw new InvalidStateException('Email address configuration must be array');
				}

				if(count($address)) {
					$name = (isset($address[1])) ? $address[1] : null;
					$addressContainer->addSetup('addAddress', array($id, array($address[0], $name)));
				}
			}
		}
	}

	/**
	 * @param Configurator $configurator
	 */
	public static function register(Configurator $configurator)
	{
		$configurator->onCompile[] = function ($config, $compiler) {
			$compiler->addExtension('emails', new EmailsExtension());
		};
	}

}