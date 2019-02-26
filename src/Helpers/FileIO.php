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

use Maslosoft\Cli\Shared\ConfigDetector;

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

	public static function write($filename, $data)
	{
		$path = self::getRootPath($filename);
		$dir = dirname($path);
		if (!file_exists($dir))
		{
			mkdir($dir, 0777, true);
		}
		return file_put_contents($path, $data);
	}

}
