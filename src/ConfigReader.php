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
	 * @var ConfigAdapterInterface|null
	 */
	private ?ConfigAdapterInterface $_adapter;
	private ?array $_phpConfig;
	private ?array $_srcConfig = null;
	private string $_basename;

	public function __construct($basename, ConfigAdapterInterface $adapter = null)
	{
		$this->_basename = $basename;
		$this->_adapter = $adapter;

		if (PHP_SAPI === 'cli')
		{
			$this->_srcConfig = $this->getAdapter()->read($this->_basename);
		}
		if (!empty($this->_srcConfig))
		{
			// Source config in found, write it to php config for later use and better performance
			$this->_phpConfig = $this->_srcConfig;
		}
		else
		{
			$this->_phpConfig = (new PhpRuntimeAdapter($this))->read($this->_basename);
		}
	}

	/**
	 * Get configuration as php array
	 * @return mixed[]
	 */
	public function toArray(): array
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
	public function getAdapter(): ConfigAdapterInterface
	{
		if (null === $this->_adapter)
		{
			$this->_adapter = new YamlAdapter();
		}
		return $this->_adapter;
	}

	public function setAdapter(ConfigAdapterInterface $adapter): void
	{
		$this->_adapter = $adapter;
	}

}
