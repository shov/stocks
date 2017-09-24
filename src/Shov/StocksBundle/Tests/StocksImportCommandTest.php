<?php

namespace Shov\StocksBundle\Tests;

use Shov\StocksBundle\Command\StocksImportCommand;
use Shov\StocksBundle\Tests\Fixtures\CommandTestCase;
use Symfony\Component\Filesystem\Filesystem;

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

    /**
     * @test
     */
    public function takeWrongCSV()
    {
        $commandTester = $this->getCommandTesterFor(new StocksImportCommand());

        $content = "Something definitely not CSV";

        $fs = new Filesystem();
        $path = $fs->tempnam('/tmp', 'StockTest');
        $fs->appendToFile($path, $content);

        try {
            $commandTester->execute(['source' => $path]);
        } catch (\Throwable $e) {
            $this->fail(sprintf("On Exception '%s'", $e->getMessage()));
        }

        $this->assertContains(
            StocksImportCommand::MESSAGES['WRONG_FILE'],
            $commandTester->getDisplay()
        );
    }

    /**
     * @test
     * @dataProvider takeSomeDataProvider
     */
    public function takeSomeData($content, $successed, $failed)
    {

    }

    public function takeSomeDataProvider()
    {
        return [
            [
                "P0001;TV;32”;Tv;10;399.99;\n",
                0,
                1,
            ],
        ];
    }

}