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


use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class FilesFinder extends Finder

{
	public function sortByName($desc = false)
	{
		if ($desc)
		{
			$sortFunc = function ($a, $b) {
				/* @var $a SplFileInfo */
				/* @var $b SplFileInfo */

				return strcmp($b->getRealpath() ?: $b->getPathname(), $a->getRealpath() ?: $a->getPathname());
			};
			return $this->sort($sortFunc);
		}
		return parent::sortByName();
	}

	public function sortByType($desc = false)
	{
		if ($desc)
		{
			$sortFunc = function ($a, $b) {
				/* @var $a SplFileInfo */
				/* @var $b SplFileInfo */

				if ($a->isDir() && $b->isFile())
				{
					return 1;
				} elseif ($a->isFile() && $b->isDir())
				{
					return -1;
				}

				return strcmp($b->getRealpath() ?: $b->getPathname(), $a->getRealpath() ?: $a->getPathname());
			};
			return $this->sort($sortFunc);
		}

		return parent::sortByType();
	}

	public function sortByAccessedTime($desc = false)
	{
		if ($desc)
		{
			$sortFunc = function ($a, $b) {
				return $b->getATime() - $a->getATime();
			};
			return $this->sort($sortFunc);
		}
		return parent::sortByAccessedTime();
	}

	public function sortByChangedTime($desc = false)
	{
		if ($desc)
		{
			$sortFunc = function ($a, $b) {
				return $b->getCTime() - $a->getCTime();
			};
			return $this->sort($sortFunc);
		}
		return parent::sortByChangedTime();
	}

	public function sortByModifiedTime($desc = false)
	{
		if ($desc)
		{
			$sortFunc = function ($a, $b) {
				return $b->getMTime() - $a->getMTime();
			};
			return $this->sort($sortFunc);
		}
		return parent::sortByModifiedTime();
	}
}