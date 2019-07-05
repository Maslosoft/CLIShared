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

use function file_exists;
use function is_dir;

/**
 * Io
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Io
{

	/**
	 * Create recursive directory structure preserving
	 * permissions on each directory level.
	 *
	 * @param     $path
	 * @param int $permissions
	 */
	public static function mkdir($path, $permissions = 0777)
	{
		// TODO Do not use umask, but split by separator and use loop
		$mask = umask(0000);
		mkdir($path, $permissions, true);
		umask($mask);
	}

	public static function dirExists($path)
	{
		$exists = file_exists($path);
		if($exists && is_dir($path))
		{
			return true;
		}
		return false;
	}

	/**
	 * Create temporary directory
	 *
	 * @param string $dir The directory where the temporary filename will be created.
	 * @param string $prefix The prefix of the generated temporary filename. Windows uses only the first three characters of prefix.
	 *
	 * @return string The new temporary filename (with path), or FALSE on failure.
	 */
	public static function tempDir($dir, $prefix = '')
	{
		$filename = tempnam($dir, $prefix);
		$dirname = $filename . 'dir';
		// Silence out errors to get return value of mkdir
		$level = error_reporting();
		error_reporting(0);
		$mask = umask(0);
		if (!mkdir($dirname, 0777))
		{
			return false;
		}
		umask($mask);
		unlink($filename);
		error_reporting($level);
		return $dirname;
	}

}
