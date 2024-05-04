<?php

namespace Maslosoft\Cli\Shared\Widgets;

use LogicException;
use Maslosoft\Cli\Shared\Log\Loggalize;
use Symfony\Component\Console\Helper\ProgressBar as PB;

class ProgressBar
{
	private static PB $currentInstance;

	public static function create(int $total): PB
	{
		$output = Loggalize::getOutput();
		self::$currentInstance = $pb = new PB($output, $total);

		$pb->setBarWidth(80);
		$pb->setFormat('very_verbose');
		$pb->setBarCharacter("\033[32m▓\033[0m");
		$pb->setEmptyBarCharacter("\033[31m▓\033[0m");
		$pb->setProgressCharacter("\033[32m▒\033[0m");

		$pb->start();
		return $pb;
	}

	public static function get(): PB
	{
		if(!isset(self::$currentInstance))
		{
			throw new LogicException("The progress bar need to be initialized before can be `get`");
		}
		return self::$currentInstance;
	}
}