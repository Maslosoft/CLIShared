<?php

namespace Maslosoft\Cli\Shared\Adapters;

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
		file_put_contents($basename . '.php', var_export($configuration, true));
	}

}
