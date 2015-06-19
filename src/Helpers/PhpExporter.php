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

namespace Maslosoft\Cli\Shared\Helpers;

class PhpExporter
{

	public static function export($data, $header = '')
	{
		$template = <<<TPL
<?php // %s
return %s;

TPL;
		return sprintf($template, $header, var_export($data, true));
	}

}
