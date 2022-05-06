<?php namespace Io;

use Codeception\Test\Unit;
use Maslosoft\Cli\Shared\Io;
use UnitTester;
use function array_reverse;
use function clearstatcache;
use function decoct;
use function fileperms;
use function rmdir;
use function substr;

class MkdirTest extends Unit
{
	/**
	 * @var UnitTester
	 */
	protected $tester;

	protected function _before(): void
	{
		$dirs = [
			__DIR__ . '/data',
			__DIR__ . '/data/test',
			__DIR__ . '/data/test/dir',
		];
		foreach (array_reverse($dirs) as $dir)
		{
			if(Io::dirExists($dir))
			{
				rmdir($dir);
			}
		}
	}

	protected function _after(): void
	{
	}

	// tests
	public function testCreatingDirRecursively(): void
	{
		$path = __DIR__ . '/data/test/dir';
		Io::mkdir($path);

		$dirs = [
			__DIR__ . '/data',
			__DIR__ . '/data/test',
			__DIR__ . '/data/test/dir',
		];
		foreach ($dirs as $dir)
		{
			$this->assertDirectoryExists($dir);
			clearstatcache();
			$permissions = (int)substr(decoct(fileperms($dir)),2);
			$this->assertSame(777, $permissions);
		}
	}

	public function testCreatingDirRecursivelyWithPathHavingForwardSlash(): void
	{
		$path = __DIR__ . '/data/test/dir/';
		Io::mkdir($path);

		$dirs = [
			__DIR__ . '/data',
			__DIR__ . '/data/test',
			__DIR__ . '/data/test/dir',
		];
		foreach ($dirs as $dir)
		{
			$this->assertDirectoryExists($dir);
			clearstatcache();
			$permissions = (int)substr(decoct(fileperms($dir)),2);
			$this->assertSame(777, $permissions);
		}
	}
}