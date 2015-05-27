<?php

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
		return file_put_contents($path, $data);
	}

}
