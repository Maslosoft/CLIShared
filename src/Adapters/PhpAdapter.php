<?php

/**
 * This software package is licensed under `AGPL, Commercial` license[s].
 *
 * @package maslosoft/cli-shared
 * @license AGPL, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 *
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

	public function write($basename, $configuration)
	{
		FileIO::write($basename . '.php', PhpExporter::export($configuration));
	}

}
