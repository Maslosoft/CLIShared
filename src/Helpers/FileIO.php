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

	public static function read($filename)
	{
		$path = self::getRootPath($filename);
		if (!file_exists($path))
		{
			return null;
		}
		return file_get_contents($path);
	}

	public static function write(string $filename, $data)
	{
		$path = self::getRootPath($filename);
		$dir = dirname($path);
		if (!file_exists($dir))
		{
			Io::mkdir($dir);
		}
		return file_put_contents($path, $data);
	}

	public static function symlink(string $target, string $link, bool $relative = true)
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
