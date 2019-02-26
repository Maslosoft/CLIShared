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

namespace Maslosoft\Cli\Shared\Helpers;

use ReflectionObject;
use function strpos;
use function substr_count;

class PhpExporter
{
	const DefaultTemplate = <<<TPL
<?php // %s
return %s;

TPL;

	/**
	 * Export PHP data into parsable code. Additionally
	 * `$header` might be provided or custom template.
	 *
	 * If template contains one `%s` placeholder it
	 * will be replaced with exported data.
	 *
	 * If `$template` contains two `%s` placeholders,
	 * the first one will be replaced with `$header`,
	 * the latter one with exported data.
	 *
	 * The default template will generate code that
	 * cen be included in any code part, for which will
	 * return exported data as variable.
	 *
	 *
	 * The default template is made as follows:
	 *
	 * ```php
	 * <?php // %s
	 * return %s;
	 *
	 * ```
	 *
	 * Which might result in following code after exporting
	 * data:
	 *
	 * For instance, the function call:
	 *
	 * ```php
	 * PhpExporter::export(['value' => 1], 'My header');
	 * ```
	 *
	 * Will result in output of PHP's parsable **string**:
	 *
	 * ```plain
	 * <?php // My header
	 * return [
	 * 		'value' => 1
	 * ];
	 * ```
	 * Example usage of exported data with default template:
	 *
	 * ```php
	 * $myVar = require 'file-with-exported-data.php';
	 * // $myVar contains: ['value' => 1]
	 * ```
	 *
	 * @param mixed  $data
	 * @param string $header
	 * @param null   $template
	 * @return string
	 */
	public static function export($data, $header = '', $template = null)
	{
		if (null === $template)
		{
			$template = self::DefaultTemplate;
		}

		assert(strpos($template, '%s') !== false, 'The `$template` must contain one or two %s placeholders');
		assert(substr_count($template, '%s') < 3, 'The `$template` must contain at most two %s placeholders');

		// For some reason tabs are doubled... Trim them to single tab.
		$export = self::dump($data);
		if(substr_count($template, '%s') === 1)
		{
			return sprintf($template, $export);
		}
		return sprintf($template, $header, $export);
	}

	private static function dump($data, $ident = 0)
	{
		$i = str_repeat("\t", $ident);
		$result = '';
		if (is_object($data))
		{
			$info = new ReflectionObject($data);
			$defaults = get_class_vars($info->name);

			$result .= sprintf("\%s::__set_state(", $info->name);
			// Convert to array, so it can be exported easier
			$dataArray = [];
			foreach ($info->getProperties() as $property)
			{
				// Skip static
				if ($property->isStatic())
				{
					continue;
				}

				// Skip private
				if ($property->isPrivate())
				{
					continue;
				}
				$name = $property->name;

				// NOTE: Do *not* skip unset properties
				// es these can have value changed.

				$property->setAccessible(true);
				$value = $property->getValue($data);

				// Skip if has default value
				if (isset($defaults[$name]) && $defaults[$name] === $value)
				{
					continue;
				}
				$dataArray[$name] = $value;
			}
			if (empty($dataArray))
			{
				// Just "[]" so ignore indentation
				$ident = 0;
			}
			$result .= self::dump($dataArray, $ident);
			$result .= ")";
			return $result;
		}
		elseif (is_array($data))
		{
			if (empty($data))
			{
				return "[]";
			}
			$result .= "[\n";
			$ident++;
			$i = str_repeat("\t", $ident);
			foreach ($data as $key => $value)
			{
				// Use var_export for keys too to prevent numeric keys
				$itemIdent = 0;
				if (!empty($value))
				{
					if (is_object($value) || is_array($value))
					{
						$itemIdent = $ident;
					}
				}
				$result .= sprintf($i . "%s => %s,\n", var_export($key, true), self::dump($value, $itemIdent));
			}

			// Shift right closing bracket
			$ident--;
			$i = str_repeat("\t", $ident);
			$result .= $i . "]";
			return $result;
		}
		else
		{
			return $i . var_export($data, true);
		}
	}

}
