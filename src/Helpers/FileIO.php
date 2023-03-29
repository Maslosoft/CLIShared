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

namespace Maslosoft\Cli\Shared\Helpers;

use Maslosoft\Cli\Shared\Cmd;
use Maslosoft\Cli\Shared\ConfigDetector;
use Maslosoft\Cli\Shared\Io;
use function assert;
use function escapeshellarg;
use function implode;

class FileIO
{

	public static function getRootPath($filename = '')
	{
		$path = (new ConfigDetector())->getRootPath();
		if (!empty($path))
		{
			return rtrim($path, '/\\') . '/' . $filename;
		}
		return $filename;
	}

	/**
	 * Read file if it exists or returns null otherwise
	 * @param $filename
	 * @return string|null
	 */
	public static function read($filename): string|null
	{
		$path = self::getRootPath($filename);
		if (!file_exists($path))
		{
			return null;
		}
		return file_get_contents($path);
	}

	/**
	 * Write data to a file while creating new directories too
	 * @param string $filename
	 * @param string $data
	 * @return false|int
	 */
	public static function write(string $filename, string $data): false|int
	{
		$path = self::getRootPath($filename);
		$dir = dirname($path);
		if (!file_exists($dir))
		{
			Io::mkdir($dir);
		}
		return file_put_contents($path, $data);
	}

	/**
	 * Create symlink.
	 * NOTE: Unix only!
	 * @param string $target
	 * @param string $link
	 * @param bool   $relative
	 * @return void
	 */
	public static function symlink(string $target, string $link, bool $relative = true): void
	{
		assert(!empty($target));
		assert(!empty($link));
		$cmd = [
			'ln'
		];
		if($relative)
		{
			$cmd[] = '-sr';
		}
		else
		{
			$cmd[] = '-s';
		}
		$cmd[] = escapeshellarg($target);
		$cmd[] = escapeshellarg($link);
		Cmd::run(implode(' ', $cmd));
	}
}
