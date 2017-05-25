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
 * Io
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Io
{

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
		if (!mkdir($dirname))
		{
			return false;
		}
		unlink($filename);
		error_reporting($level);
		return $dirname;
	}

}
