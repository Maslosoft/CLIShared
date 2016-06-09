<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Cli\Shared;

/**
 * Operating system helper methods
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Os
{

	public static function isWindows()
	{
		return defined('PHP_WINDOWS_VERSION_MAJOR');
	}

	public static function isUnix()
	{
		return !defined('PHP_WINDOWS_VERSION_MAJOR');
	}

}
