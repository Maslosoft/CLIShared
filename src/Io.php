<?php

/**
 * This software package is dual licensed under AGPL and Proprietary license.
 *
 * @package   maslosoft/cli-shared
 * @licence   AGPL or Proprietary
 * @copyright Copyright (c) Piotr Masełkowski <peter@maslosoft.com>
 * @copyright Copyright (c) Maslosoft
 * @link      https://maslosoft.com/cli-shared/
 */

namespace Maslosoft\Cli\Shared;

use RuntimeException;
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
		if (!mkdir($path, $permissions, true) && !is_dir($path))
		{
			throw new RuntimeException(sprintf('Directory "%s" was not created', $path));
		}
		umask($mask);
	}

	public static function dirExists($path)
	{
		$exists = file_exists($path);
		return $exists && is_dir($path);
	}

	/**
	 * Create temporary directory
	 *
	 * @param string $dir    The directory where the temporary filename will be created.
	 * @param string $prefix The prefix of the generated temporary filename. Windows uses only the first three
	 *                       characters of prefix.
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
		if (!mkdir($dirname, 0777) && !is_dir($dirname))
		{
			return false;
		}
		umask($mask);
		unlink($filename);
		error_reporting($level);
		return $dirname;
	}

	/**
	 * Copy a file, or recursively copy a folder and its contents
	 * @param string $source      Source path
	 * @param string $dest        Destination path
	 * @param int    $permissions New folder creation permissions
	 * @return      bool     Returns true on success, false on failure
	 * @author      Aidan Lister <aidan@php.net>
	 * @version     1.0.1
	 * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
	 * @link        https://stackoverflow.com/a/12763962/5444623
	 */
	public static function xcopy(string $source, string $dest, int $permissions = 0755): bool
	{
		// Check for symlinks
		if (is_link($source))
		{
			return symlink(readlink($source), $dest);
		}

		// Simple copy for a file
		if (is_file($source))
		{
			return copy($source, $dest);
		}

		// Make destination directory
		if (!is_dir($dest))
		{
			self::mkdir($dest, $permissions);
		}

		// Loop through the folder
		$dir = dir($source);
		while (false !== $entry = $dir->read())
		{
			// Skip pointers
			if ($entry === '.' || $entry === '..')
			{
				continue;
			}

			// Deep copy directories
			self::xcopy("$source/$entry", "$dest/$entry", $permissions);
		}

		// Clean up
		$dir->close();
		return true;
	}

	/**
	 * Recursively remove directory
	 * @param string $dir
	 * @link https://stackoverflow.com/a/3338133/5444623
	 */
	public static function rmdir(string $dir): void
	{
		if (is_dir($dir))
		{
			$objects = scandir($dir);
			foreach ($objects as $object)
			{
				if ($object !== '.' && $object !== '..')
				{
					if (is_dir($dir . "/" . $object) && !is_link($dir . "/" . $object))
					{
						self::rmdir($dir . "/" . $object);
					}
					else
					{
						unlink($dir . "/" . $object);
					}
				}
			}
			rmdir($dir);
		}
	}
}
