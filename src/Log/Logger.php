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
class Logger extends Base implements LoggerInterface
{

	/**
	 * Output
	 * @var OutputInterface
	 */
	private $output = null;

	public function __construct(OutputInterface $output)
	{
		$this->output = $output;
	}

	protected function add($level, $message)
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
