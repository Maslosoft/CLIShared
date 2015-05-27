<?php

namespace Maslosoft\Cli\Shared\Adapters\Internal;

use Maslosoft\Cli\Shared\Adapters\PhpAdapter;
use Maslosoft\Cli\Shared\ConfigReader;
use Maslosoft\Cli\Shared\Helpers\FileIO;
use Maslosoft\Cli\Shared\Helpers\PhpExporter;

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
		return parent::read('runtime/' . $basename);
	}

	public function write($basename, $configuration)
	{
		$text = PhpExporter::export($configuration, 'Auto generated, any changes will be lost');
		FileIO::write('runtime/' . $basename . '.php', $text);
	}

}
