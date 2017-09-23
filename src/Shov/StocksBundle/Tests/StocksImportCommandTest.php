<?php

namespace Shov\StocksBundle\Tests;

use Shov\StocksBundle\Command\StocksImportCommand;
use Shov\StocksBundle\Tests\Fixtures\CommandTestCase;

/**
 * Class StocksImportCommandTest
 * @package Shov\StocksBundle\Tests
 * @cover \Shov\StocksBundle\Command\StocksImportCommand
 */
class StocksImportCommandTest extends CommandTestCase
{
    /**
     * @test
     */
    public function startWithoutPath()
    {
        $commandTester = $this->getCommandTesterFor(new StocksImportCommand());

        try {
            $commandTester->execute([]);
            $this->fail("The exception expects");
        } catch (\Throwable $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @test
     */
    public function takeWrongPath()
    {
        $commandTester = $this->getCommandTesterFor(new StocksImportCommand());
        $wrongPath = '/ddd/ddd/ddd/ddd' . time();

        try {
            $commandTester->execute(['source' => $wrongPath]);
        } catch (\Throwable $e) {
            $this->fail(sprintf("On Exception '%s'", $e->getMessage()));
        }

        $this->assertContains(
            StocksImportCommand::MESSAGES['WRONG_PATH'],
            $commandTester->getDisplay()
        );
    }
}