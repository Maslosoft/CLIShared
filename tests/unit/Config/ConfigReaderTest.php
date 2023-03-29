<?php


namespace Unit\Config;

use Codeception\Test\Unit;
use Maslosoft\Cli\Shared\Adapters\YamlAdapter;
use Maslosoft\Cli\Shared\ConfigReader;
use \UnitTester;

class ConfigReaderTest extends Unit
{

    protected UnitTester $tester;

    protected function _before(): void
    {
    }

    // tests
    public function testReadingYmlConfig(): void
    {
		$rootPath = realpath(__DIR__ . '/../../..');
		$basename = 'tests/unit/Config/data/config';
		$cachedBasename = $rootPath . '/runtime/tests/unit/Config/data/config.php';
		if(file_exists($cachedBasename))
		{
			unlink($cachedBasename);
		}
		$this->assertFileExists($basename . '.yml');
		$adapter = new YamlAdapter();
		$reader = new ConfigReader($basename, $adapter);
		$data =  $reader->toArray();
		$reader = null;
		codecept_debug($data);
		$this->assertNotEmpty($data);
		$this->assertFileExists($cachedBasename);
    }
}
