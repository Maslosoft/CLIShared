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
