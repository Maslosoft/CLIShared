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
	private $_phpConfig;
	private $_srcConfig;

	public function __construct($basename, ConfigAdapterInterface $adapter = null)
	{
		$this->_basename = $basename;
		$this->_adapter = $adapter;
		$this->_srcConfig = null;
		if (php_sapi_name() == 'cli')
		{
			$this->_srcConfig = $this->getAdapter()->read($this->_basename);
		}
		if (!empty($this->_srcConfig))
		{
			// Source config in found, write it to php cafig for later use and better performance
			$this->_phpConfig = $this->_srcConfig;
		}
		else
		{
			$this->_phpConfig = (new PhpRuntimeAdapter($this))->read($this->_basename);
		}
	}

	/**
	 * Get confguration as php array
	 * @return mixed[]
	 */
	public function toArray()
	{
		if (empty($this->_phpConfig))
		{
			return [];
		}
		return (array) $this->_phpConfig;
	}

	public function __destruct()
	{
		if (!empty($this->_srcConfig))
		{
			(new PhpRuntimeAdapter($this))->write($this->_basename, $this->_phpConfig);
		}
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
