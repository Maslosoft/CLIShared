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

use Symfony\Component\Finder\Finder;

/**
 * FinderFactory
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class FinderFactory
{

	public function __construct()
	{
		
	}

	public function create($config = [])
	{
		$finder = new Finder();
	}

}
