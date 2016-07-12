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
