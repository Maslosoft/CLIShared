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
		// For some reason tabs are doubled... Trim them to single tab.
		$export = str_replace("\t\t", "\t", self::dump($data));
		return sprintf($template, $header, $export);
	}

	private static function dump($data, $ident = 0)
	{
		$i = str_repeat("\t", $ident++);
		$result = '';
		if (is_object($data))
		{
			$info = new \ReflectionObject($data);
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

				// Skip unset properties
				if ($property->isPublic() && !isset($data->$name))
				{
					continue;
				}
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
				// Just "[]" so ignore identation
				$i = '';
				$ident = 0;
			}
			else
			{
				// Decrease ident, as we do another dump here
				$ident--;
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

			// Shift left closing bracket
			$ident--;
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
