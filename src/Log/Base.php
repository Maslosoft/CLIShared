<?php

/**
 * This software package is dual licensed under AGPL and Proprietary license.
 *
 * @package maslosoft/cli-shared
 * @licence AGPL or Proprietary
 * @copyright Copyright (c) Piotr Masełkowski <peter@maslosoft.com>
 * @copyright Copyright (c) Maslosoft
 * @link https://maslosoft.com/cli-shared/
 */

namespace Maslosoft\Cli\Shared\Log;


use Stringable;

abstract class Base
{
	public const LevelHigh = 3;
	public const LevelMid = 2;
	public const LevelLow = 1;
	public const LevelDebug = 0;

	abstract protected function add($level, $message, $context = []);

	/**
	 * System is unusable.
	 *
	 * @param string|Stringable $message
	 * @param array             $context
	 */
	public function emergency(string|Stringable $message, array $context = []): void
	{
		$this->add(self::LevelHigh, $message, $context);
	}

	/**
	 * Action must be taken immediately.
	 *
	 * Example: Entire website down, database unavailable, etc. This should
	 * trigger the SMS alerts and wake you up.
	 *
	 * @param string|Stringable $message
	 * @param array             $context
	 */
	public function alert(string|Stringable $message, array $context = []): void
	{
		$this->add(self::LevelHigh, $message, $context);
	}

	/**
	 * Critical conditions.
	 *
	 * Example: Application component unavailable, unexpected exception.
	 *
	 * @param string|Stringable $message
	 * @param array             $context
	 */
	public function critical(string|Stringable $message, array $context = []): void
	{
		$this->add(self::LevelHigh, $message, $context);
	}

	/**
	 * Runtime errors that do not require immediate action but should typically
	 * be logged and monitored.
	 *
	 * @param string|Stringable $message
	 * @param array             $context
	 */
	public function error(string|Stringable $message, array $context = []): void
	{
		$this->add(self::LevelHigh, $message, $context);
	}

	/**
	 * Exceptional occurrences that are not errors.
	 *
	 * Example: Use of deprecated APIs, poor use of an API, undesirable things
	 * that are not necessarily wrong.
	 *
	 * @param string|Stringable $message
	 * @param array             $context
	 */
	public function warning(string|Stringable $message, array $context = []): void
	{
		$this->add(self::LevelMid, $message, $context);
	}

	/**
	 * Normal but significant events.
	 *
	 * @param string|Stringable $message
	 * @param array             $context
	 */
	public function notice(string|Stringable $message, array $context = []): void
	{
		$this->add(self::LevelMid, $message, $context);
	}

	/**
	 * Interesting events.
	 *
	 * Example: User logs in, SQL logs.
	 *
	 * @param string|Stringable $message
	 * @param array             $context
	 */
	public function info(string|Stringable $message, array $context = []): void
	{
		$this->add(self::LevelLow, $message, $context);
	}

	/**
	 * Detailed debug information.
	 *
	 * @param string|Stringable $message
	 * @param array             $context
	 */
	public function debug(string|Stringable $message, array $context = []): void
	{
		$this->add(self::LevelDebug, $message, $context);
	}

	/**
	 * Logs with an arbitrary level.
	 *
	 * @param mixed             $level
	 * @param string|Stringable $message
	 * @param array             $context
	 */
	public function log($level, string|Stringable $message, array $context = []): void
	{
		$this->add($level, $message, $context);
	}

	protected function decorate(&$message, array $context = []): void
	{
		 if(empty($context))
		 {
			 return;
		 }
		// build a replacement array with braces around the context keys
		$replace = [];
		foreach ($context as $key => $val)
		{
			// check that the value can be cast to string
			if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString')))
			{
				$replace['{' . $key . '}'] = $val;
			}
		}

		// interpolate replacement values into the message and return
		$message = strtr($message, $replace);
	}
}