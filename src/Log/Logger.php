<?php

/**
 * This software package is licensed under `AGPL, Commercial` license[s].
 *
 * @package maslosoft/cli-shared
 * @license AGPL, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 */

namespace Maslosoft\Cli\Shared\Log;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Logger
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Logger implements LoggerInterface
{

	const LevelHigh = 3;
	const LevelMid = 2;
	const LevelLow = 1;
	const LevelDebug = 0;

	/**
	 * Output
	 * @var OutputInterface
	 */
	private $output = null;

	public function __construct(OutputInterface $output)
	{
		$this->output = $output;
	}

	/**
	 * System is unusable.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function emergency($message, array $context = array())
	{
		$this->add(self::LevelHigh, $message);
	}

	/**
	 * Action must be taken immediately.
	 *
	 * Example: Entire website down, database unavailable, etc. This should
	 * trigger the SMS alerts and wake you up.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function alert($message, array $context = array())
	{
		$this->add(self::LevelHigh, $message);
	}

	/**
	 * Critical conditions.
	 *
	 * Example: Application component unavailable, unexpected exception.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function critical($message, array $context = array())
	{
		$this->add(self::LevelHigh, $message);
	}

	/**
	 * Runtime errors that do not require immediate action but should typically
	 * be logged and monitored.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function error($message, array $context = array())
	{
		$this->add(self::LevelHigh, $message);
	}

	/**
	 * Exceptional occurrences that are not errors.
	 *
	 * Example: Use of deprecated APIs, poor use of an API, undesirable things
	 * that are not necessarily wrong.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function warning($message, array $context = array())
	{
		$this->add(self::LevelMid, $message);
	}

	/**
	 * Normal but significant events.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function notice($message, array $context = array())
	{
		$this->add(self::LevelMid, $message);
	}

	/**
	 * Interesting events.
	 *
	 * Example: User logs in, SQL logs.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function info($message, array $context = array())
	{
		$this->add(self::LevelLow, $message);
	}

	/**
	 * Detailed debug information.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function debug($message, array $context = array())
	{
		$this->add(self::LevelDebug, $message);
	}

	/**
	 * Logs with an arbitrary level.
	 *
	 * @param mixed $level
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function log($level, $message, array $context = array())
	{
		$this->add($level, $message);
	}

	private function add($level, $message)
	{
		if ($this->output->isQuiet())
		{
			return;
		}
		$patterns = [
			// Backtics
			'~`(.+?)`~',
			// Errors
			'~(Error\W)~',
			// Warnings
			'~(Warning\W)~'
		];
		$replacements = [
			// Backtics to info block
			'<info>$1</info>',
			// Make errors shine
			'<error>$1</error>',
			// Make warnings noticable
			'<comment>$1</comment>',
		];
		$message = preg_replace($patterns, $replacements, $message);
		// Always show high level messages:
		// emergency
		// alert
		// critical
		// error
		//
		if ($level === self::LevelHigh)
		{
			$this->output->writeln($message);
			return;
		}

		// Mid and above:
		// emergency
		// alert
		// critical
		// error
		// --
		// warning
		// notice
		//
		if ($this->output->isVerbose() && $level > self::LevelLow)
		{
			$this->output->writeln($message);
			return;
		}

		// Low and above:
		// emergency
		// alert
		// critical
		// error
		// --
		// warning
		// notice
		// --
		// info
		//
		if ($this->output->isVeryVerbose() && $level > self::LevelDebug)
		{
			$this->output->writeln($message);
			return;
		}

		// Show all messages on debug mode
		if ($this->output->isDebug())
		{
			$this->output->writeln($message);
			return;
		}
	}

}
