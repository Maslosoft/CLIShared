<?php namespace Os;

use Codeception\Test\Unit;
use Maslosoft\Cli\Shared\Os;
use UnitTester;

class OsKindTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
    
    protected function _before(): void
    {
    }

    protected function _after(): void
    {
    }

    // tests
    public function testIfWillDetectThatItIsUnix(): void
    {
		$this->assertTrue(Os::isUnix());
    }

	public function testIfWillDetectThatItIsWindows(): void
	{
		$this->assertFalse(Os::isWindows());
	}
}