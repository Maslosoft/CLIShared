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

	public static function isWindows()
	{
		return defined('PHP_WINDOWS_VERSION_MAJOR');
	}

	public static function isUnix()
	{
		return !defined('PHP_WINDOWS_VERSION_MAJOR');
	}

}
