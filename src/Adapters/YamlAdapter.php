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
use Maslosoft\Cli\Shared\Interfaces\ConfigAdapterInterface;
use Symfony\Component\Yaml\Yaml;

class YamlAdapter implements ConfigAdapterInterface
{

	public function read($basename)
	{
		return Yaml::parse(FileIO::read($basename . '.yml'));
	}

	public function write($basename, $configuration)
	{
		return FileIO::write($basename . '.yml', Yaml::dump($configuration, 4));
	}

}
