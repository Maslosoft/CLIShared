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


use const FILE_APPEND;
use function file_put_contents;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FileLogger extends Base implements LoggerInterface
{
	private $filename = '';

	/**
	 * Output
	 * @var OutputInterface
	 */
	private $output = null;

	/**
	 * FileLogger constructor.
	 * @param string $filename Base filename
	 * @param bool $datePrefix Whether to add date prefix to file name
	 */
	public function __construct(OutputInterface $output, $filename = 'op.log', $datePrefix = true)
	{
		$this->output = $output;
		$this->filename = $filename;
		if($datePrefix)
		{
			$this->filename = sprintf('%s_%s', date('Y-m-d'), $this->filename);
		}
	}

	protected function add($level, $message)
	{
		if ($this->output->isQuiet())
		{
			return;
		}

		// Always show high level messages:
		// emergency
		// alert
		// critical
		// error
		//
		if ($level === self::LevelHigh)
		{
			$this->writeln($message);
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
			$this->writeln($message);
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
			$this->writeln($message);
			return;
		}

		// Show all messages on debug mode
		if ($this->output->isDebug())
		{
			$this->writeln($message);
			return;
		}
	}

	private function writeln($message)
	{
		@file_put_contents($this->filename, $message, FILE_APPEND);
	}
}