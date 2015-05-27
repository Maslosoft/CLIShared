<?php

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
		if (php_sapi_name() === 'cli')
		{
			return getcwd();
		}
	}

	public function getVendorPath()
	{
		// Get vendor path, similarly as getRootPath
	}

}
