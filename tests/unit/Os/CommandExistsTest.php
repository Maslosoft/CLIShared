<?php namespace Os;

use Codeception\Test\Unit;
use Maslosoft\Cli\Shared\Os;
use UnitTester;

class CommandExistsTest extends Unit
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
    public function testIfLsCommandExists(): void
    {
		$this->assertTrue(Os::commandExists('ls'));
    }

	public function testIfSomeCommandNotExists(): void
	{
		$this->assertFalse(Os::commandExists('ascsncac88789as8c76v6vvxxxxx7x77x7x7x7xxx'));
	}
}