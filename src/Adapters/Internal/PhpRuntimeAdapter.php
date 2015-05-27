<?php

namespace Maslosoft\Cli\Shared\Adapters\Internal;

use Maslosoft\Cli\Shared\Adapters\PhpAdapter;
use Maslosoft\Cli\Shared\ConfigReader;

class PhpRuntimeAdapter extends PhpAdapter
{

	private $_reader = null;

	public function __construct(ConfigReader $reader)
	{
		// $reade param is only to limit this class usage to internal usage by ConfigReader
		$this->_reader = $reader;
	}

	public function read($basename)
	{

	}

	public function write($basename, $configuration)
	{

	}

}
