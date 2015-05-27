<?php

namespace Maslosoft\Cli\Shared;

use Maslosoft\Cli\Shared\Adapters\Internal\PhpRuntimeAdapter;
use Maslosoft\Cli\Shared\Adapters\YamlAdapter;
use Maslosoft\Cli\Shared\Interfaces\ConfigAdapterInterface;

/**
 * DRAFT
 * This should read config.yml on cli, and write it to `generated` folder as php file.
 * From php this should only read php config. Should allow uniform property-like access
 */
class ConfigReader
{

	/**
	 *
	 * @var ConfigAdapterInterface
	 */
	private $_adapter = null;

	public function __construct($basename, ConfigAdapterInterface $adapter = null)
	{
		$this->_adapter = $adapter;
		if (php_sapi_name() == 'cli')
		{
			$srcConfig = $this->getAdapter()->read($basename);
		}
		$phpConfig = (new PhpRuntimeAdapter($this))->read($basename);
	}

	/**
	 *
	 */
	public function getAdapter()
	{
		if (null === $this->_adapter)
		{
			$this->_adapter = new YamlAdapter();
		}
		return $this->_adapter;
	}

	public function setAdapter(ConfigAdapterInterface $adapter)
	{
		$this->_adapter = $adapter;
	}

}
