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
	private ?ConfigAdapterInterface $adapter;
	private ?array $phpConfig;
	private ?array $srcConfig = null;
	private string $basename;

	public function __construct($basename, ConfigAdapterInterface $adapter = null)
	{
		$this->basename = $basename;
		$this->adapter = $adapter;

		if (PHP_SAPI === 'cli')
		{
			$this->srcConfig = $this->getAdapter()->read($this->basename);
		}
		if (!empty($this->srcConfig))
		{
			// Source config in found, write it to php config for later use and better performance
			$this->phpConfig = $this->srcConfig;
		}
		else
		{
			$this->phpConfig = (new PhpRuntimeAdapter($this))->read($this->basename);
		}
	}

	/**
	 * Get configuration as php array
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		if (empty($this->phpConfig))
		{
			return [];
		}
		return (array) $this->phpConfig;
	}

	public function __destruct()
	{
		if (!empty($this->srcConfig))
		{
			(new PhpRuntimeAdapter($this))->write($this->basename, $this->phpConfig);
		}
	}

	/**
	 *
	 */
	public function getAdapter(): ConfigAdapterInterface
	{
		if (null === $this->adapter)
		{
			$this->adapter = new YamlAdapter();
		}
		return $this->adapter;
	}

	public function setAdapter(ConfigAdapterInterface $adapter): void
	{
		$this->adapter = $adapter;
	}

}
