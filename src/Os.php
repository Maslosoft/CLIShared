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
 * Operating system helper methods
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Os
{

	public static function isWindows()
	{
		return defined('PHP_WINDOWS_VERSION_MAJOR');
	}

	public static function isUnix()
	{
		return !defined('PHP_WINDOWS_VERSION_MAJOR');
	}

}
