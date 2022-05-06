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

namespace Maslosoft\Cli\Shared;

/**
 * Operating system helper methods
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Os
{

	public static function isWindows(): bool
	{
		return defined('PHP_WINDOWS_VERSION_MAJOR');
	}

	public static function isUnix(): bool
	{
		return !defined('PHP_WINDOWS_VERSION_MAJOR');
	}

	/**
	 * Determines if a command exists on the current environment
	 *
	 * @see https://stackoverflow.com/a/18540185/5444623
	 * @param string $command The command to check
	 * @return bool True if the command has been found ; otherwise, false.
	 */
	public static function commandExists(string $command): bool
	{
		$whereIsCommand = self::isWindows() ? 'where' : 'which';

		$process = proc_open(
			"$whereIsCommand $command",
			[
				0 => ["pipe", "r"], //STDIN
				1 => ["pipe", "w"], //STDOUT
				2 => ["pipe", "w"], //STDERR
			],
			$pipes
		);
		if ($process !== false) {
			$stdout = stream_get_contents($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);
			proc_close($process);

			return $stdout !== '';
		}

		return false;
	}
}
