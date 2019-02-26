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
use Maslosoft\Cli\Shared\Interfaces\ConfigAdapterInterface;
use Symfony\Component\Yaml\Yaml;

class YamlAdapter implements ConfigAdapterInterface
{

	public function read($basename)
	{
		$yamlConfig = FileIO::read($basename . '.yml');
		if(empty($yamlConfig))
		{
			return [];
		}
		return Yaml::parse($yamlConfig);
	}

	public function write($basename, $configuration)
	{
		return FileIO::write($basename . '.yml', Yaml::dump($configuration, 4));
	}

}
