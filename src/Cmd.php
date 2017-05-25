<?php

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
			exec($command . " > /dev/null &");
		}
	}

}
