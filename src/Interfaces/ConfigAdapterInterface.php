<?php

namespace Maslosoft\Cli\Shared\Interfaces;

interface ConfigAdapterInterface
{

	public function read($basename);

	public function write($basename, $configuration);
}
