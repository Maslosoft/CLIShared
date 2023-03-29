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

namespace Maslosoft\Cli\Shared\Adapters\Internal;

use Maslosoft\Cli\Shared\Adapters\PhpAdapter;
use Maslosoft\Cli\Shared\ConfigReader;
use Maslosoft\Cli\Shared\Helpers\FileIO;
use Maslosoft\Cli\Shared\Helpers\PhpExporter;

class PhpRuntimeAdapter extends PhpAdapter
{
	public function read($basename)
	{
		return parent::read('runtime/' . $basename);
	}

	public function write($basename, $configuration): false|int
	{
		$text = PhpExporter::export($configuration, 'Auto generated, any changes will be lost');
		return FileIO::write('runtime/' . $basename . '.php', $text);
	}

}
