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

namespace Maslosoft\Cli\Shared\Adapters;

use Maslosoft\Cli\Shared\Helpers\FileIO;
use Maslosoft\Cli\Shared\Helpers\PhpExporter;
use Maslosoft\Cli\Shared\Interfaces\ConfigAdapterInterface;

class PhpAdapter implements ConfigAdapterInterface
{

	public function read($basename)
	{
		// @ is used here on purpose, to avoid file_exists checks
		$config = @include $basename . '.php';
		if (empty($config))
		{
			return null;
		}
		return $config;
	}

	public function write($basename, $configuration): false|int
	{
		return FileIO::write($basename . '.php', PhpExporter::export($configuration));
	}

}
