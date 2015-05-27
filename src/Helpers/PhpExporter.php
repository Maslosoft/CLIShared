<?php

namespace Maslosoft\Cli\Shared\Helpers;

class PhpExporter
{

	public static function export($data, $header = '')
	{
		$template = <<<TPL
<?php
	// %s
	return %s;
TPL;
		return sprintf($template, $header, var_export($data, true));
	}

}
