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
	public function sortByName(bool $desc = false): static
	{
		if ($desc)
		{
			$this->reverseSorting();
		}
		return parent::sortByName();
	}

	public function sortByType($desc = false): static
	{
		if ($desc)
		{
			$this->reverseSorting();
		}
		return parent::sortByType();
	}

	public function sortByAccessedTime($desc = false): static
	{
		if ($desc)
		{
			$this->reverseSorting();
		}
		return parent::sortByAccessedTime();
	}

	public function sortByChangedTime($desc = false): static
	{
		if ($desc)
		{
			$this->reverseSorting();
		}
		return parent::sortByChangedTime();
	}

	public function sortByModifiedTime($desc = false): static
	{
		if ($desc)
		{
			$this->reverseSorting();
		}
		return parent::sortByModifiedTime();
	}
}