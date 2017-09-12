<?php

/**
 * This software package is licensed under `AGPL, Commercial` license[s].
 *
 * @package maslosoft/cli-shared
 * @license AGPL, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 */

namespace Maslosoft\Cli\Shared;

/**
 * Cmd
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Cmd
{

	/**
	 * Run shell command in background, without PHP waiting to finish it.
	 * @param string $command
	 */
	public static function background($command)
	{
		if (Os::isWindows())
		{
			pclose(popen("start /B " . $command, "r"));
		}
		else
		{
			self::run($command . " &");
		}
	}

	public static function run($command, & $output = null)
	{
		$pipes = [];
		$descriptorspec = [
			2 => ["pipe", "w"]
		];
		$process = proc_open($command, $descriptorspec, $pipes);

		if (is_resource($process))
		{
			$output = stream_get_contents($pipes[2]);
			fclose($pipes[2]);
			$return = proc_close($process);
		}

		return $return;
	}

}
