<?php


namespace Unit\Log;

use Codeception\Test\Unit;
use Maslosoft\Cli\Shared\Io;
use Maslosoft\Cli\Shared\Log\FileLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use \UnitTester;

class FileLoggerTest extends Unit
{

    protected UnitTester $tester;

	private string $path;

	protected function _before()
    {
		$rootDir = realpath(__DIR__ . '/../../../');
		$logPath = $rootDir . '/runtime';
		Io::mkdir($logPath);
		$this->assertIsWritable($logPath);
		$this->path = $logPath . '/file-logger-test.log';
		codecept_debug($this->path);
		@unlink($this->path);
    }

    // tests
    public function testLoggingWithContext(): void
    {
		$output = new ConsoleOutput();
		$logger = new FileLogger($output, $this->path, false);
		$logger->error("Test error: {num}", ['num' => 123]);

		$this->assertFileExists($this->path);
		$log = file_get_contents($this->path);
		$this->assertStringContainsString(123, $log);
    }
}
