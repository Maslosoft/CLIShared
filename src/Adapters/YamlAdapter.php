<?php

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
