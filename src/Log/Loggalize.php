<?php

namespace Maslosoft\Cli\Shared\Log;

use Psr\Log\LoggerAwareInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function assert;

class Loggalize
{
	private static Logger $logger;
	public static function with(object $object, OutputInterface $output): void
	{
		if($object instanceof LoggerAwareInterface)
		{
			self::$logger = new Logger($output);
			$object->setLogger(self::$logger);
		}
	}

	public static function get():Logger
	{
		assert(self::$logger instanceof Logger);
		return self::$logger;
	}
}