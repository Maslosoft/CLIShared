<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 28.11.17
 * Time: 11:13
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