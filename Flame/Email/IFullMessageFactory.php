<?php
/**
 * Class IFullMessageFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 29.08.13
 */
namespace Flame\Email;

interface IFullMessageFactory extends IMessageFactory
{

	/**
	 * @param string|EmailAddress $from
	 * @return $this
	 */
	public function setFrom($from);

	/**
	 * @param string|EmailAddress $to
	 * @return $this
	 */
	public function addReplyTo($to);

	/**
	 * @param string|EmailAddress $to
	 * @return $this
	 */
	public function addTo($to);

}