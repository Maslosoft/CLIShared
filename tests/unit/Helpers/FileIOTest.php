<?php


namespace Unit\Helpers;

use Codeception\Test\Unit;
use Maslosoft\Cli\Shared\Helpers\FileIO;
use \UnitTester;

class FileIOTest extends Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testCreatingSymlink(): void
    {
		$src = __DIR__ . '/data/test.src';
		$dst = __DIR__ . '/data/test.dst';

		if(file_exists($dst))
		{
			unlink($dst);
		}

		FileIO::symlink($src, $dst);
		$this->assertFileExists($dst);
    }
}
