<?php

namespace Maslosoft\Cli\Shared\Log;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use function assert;

class Loggalize
{
	private static Logger $logger;

	private static OutputInterface $output;

	public static function with(object $object, OutputInterface $output): void
	{
		if($object instanceof LoggerAwareInterface)
		{
			self::$output = $output;
			self::$logger = new Logger($output);
			$object->setLogger(self::$logger);
		}
	}

	public static function get():Logger|LoggerInterface
	{
		if(!isset(self::$logger))
		{
			return new NullLogger;
		}
		assert(self::$logger instanceof Logger);
		return self::$logger;
	}

	public static function getOutput(): OutputInterface
	{
		if(!isset(self::$output))
		{
			return new NullOutput;
		}
		return self::$output;
	}
}