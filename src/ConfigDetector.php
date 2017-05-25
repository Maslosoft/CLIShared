<?php

/**
 * This software package is licensed under `AGPL, Commercial` license[s].
 *
 * @package maslosoft/cli-shared
 * @license AGPL, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 */

namespace Maslosoft\Cli\Shared;

/**
 * DRAFT
 */
class ConfigDetector
{

	public function getRootPath()
	{
		// Return current running application root dir. This must work on cli and http
		if (defined('APPLICATION_ROOT'))
		{
			return constant('APPLICATION_ROOT');
		}
		return getcwd();
	}

	public function getVendorPath()
	{
		// Get vendor path, similarly as getRootPath
		return sprintf('%s/vendor', $this->getRootPath());
	}

	public function getRuntimePath()
	{
		return sprintf('%s/runtime', $this->getRootPath());
	}

	public function getGeneratedPath()
	{
		return sprintf('%s/generated', $this->getRootPath());
	}

}
