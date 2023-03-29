<?php


namespace Unit\Io;

use Codeception\Test\Unit;
use Maslosoft\Cli\Shared\Io;
use \UnitTester;

class TempDirTest extends Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testCreatingTemporaryDirectory(): void
    {
		$tmpDir = Io::tempDir('/tmp');
		$this->assertDirectoryExists($tmpDir);
		$this->assertIsWritable($tmpDir);
    }
}
