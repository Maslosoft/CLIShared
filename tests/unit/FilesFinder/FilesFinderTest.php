<?php


namespace Unit\FilesFinder;

use Codeception\Test\Unit;
use Maslosoft\Cli\Shared\FilesFinder;
use Symfony\Component\Finder\SplFileInfo;
use \UnitTester;
use function array_reverse;
use function codecept_debug;
use function touch;

class FilesFinderTest extends Unit
{

    protected UnitTester $tester;

    protected function _before(): void
    {
    }

    // tests
    public function testFindingFilesByNameDest(): void
    {
		$names = [
			'1test.a',
			'2test.c',
			'3test.x'
		];
		$dir = __DIR__ . '/data';
		foreach($names as $name)
		{
			touch("$dir/$name");
		}
		$finder = new FilesFinder();
		$finder->in($dir);
		$finder->sortByName(true);
		$result = [];
		foreach($finder as $fileInfo)
		{
			$this->assertInstanceOf(SplFileInfo::class, $fileInfo);
			$name = $fileInfo->getFilename();
			$result[] = $name;
		}
		codecept_debug($names);
		codecept_debug($result);

		$this->assertSame(array_reverse($names), $result);
    }
}
