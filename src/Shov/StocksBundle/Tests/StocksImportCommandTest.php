<?php

namespace Shov\StocksBundle\Tests;

use Moltin\Currency\Currency;
use Moltin\Currency\Exchange\ExchangeAbstract;
use Moltin\Currency\ExchangeInterface;
use Moltin\Currency\Format\Runtime;
use Shov\StocksBundle\Command\StocksImportCommand;
use Shov\StocksBundle\Tests\Fixtures\CommandTestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class StocksImportCommandTest
 * @package Shov\StocksBundle\Tests
 * @covers StocksImportCommand
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
        $wrongPath = '/abc/abc/abc/abc' . uniqid();

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

        $content = "Something definitely not CSV\n\n";

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

        @unlink($path);
    }

    /**
     * @test
     */
    public function testModeOn()
    {
        $commandTester = $this->getCommandTesterFor(new StocksImportCommand());

        $content = "Something definitely not CSV\n\n";

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

        @unlink($path);
    }

    /**
     * @test
     */
    public function testModeOff()
    {
        $commandTester = $this->getCommandTesterFor(new StocksImportCommand());

        $content = "Something definitely not CSV\n\n";

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

        @unlink($path);
    }

    /**
     * @test
     * @dataProvider takeSomeDataProvider
     */
    public function takeSomeData($content, $successful, $failed, $message)
    {
        $commandTester = $this->getCommandTesterFor(new StocksImportCommand());

        $fs = new Filesystem();
        $path = $fs->tempnam('/tmp', 'StockTest');
        $fs->appendToFile($path, $content);

        try {
            $commandTester->execute(['source' => $path]);
        } catch (\Throwable $e) {
            $this->fail(sprintf("On Exception '%s'", $e->getMessage()));
        }

        $this->assertContains(
            sprintf(StocksImportCommand::MESSAGES['SUCCESS_ITEMS'], $successful),
            $commandTester->getDisplay(),
            "On looking for successful items in " . $message
        );

        $this->assertContains(
            sprintf(StocksImportCommand::MESSAGES['FAILED_ITEMS'], $failed),
            $commandTester->getDisplay(),
            "On looking for failed items in " . $message
        );

        @unlink($path);
    }

    public function takeSomeDataProvider()
    {
        $currency = $this->getCurrencyMock();

        $lessThanFiveDollars = ($currency->convert(4.3)->from('USD')->to('GBP')->value());
        $exactFiveDollars = ($currency->convert(5)->from('USD')->to('GBP')->value());
        $moreThanFiveDollars = ($currency->convert(6)->from('USD')->to('GBP')->value());

        $lessThanThousandDollars = ($currency->convert(999)->from('USD')->to('GPB')->value());
        $exactThousandDollars = ($currency->convert(1000)->from('USD')->to('GPB')->value());
        $moreThanThousandDollars = ($currency->convert(1001)->from('USD')->to('GPB')->value());

        $lessThan10 = 9;
        $exact10 = 10;
        $moreThan10 = 11;

        $haveDiscounted = 'yes';

        $uniq = function () {
            return uniqid(rand(1, 99));
        };

        $corrupted = 'oin$on';
        $empty = '';
        $noUniqueSecondTime = $uniq();

        /**
         * CSV Format
         * Product Code,Product Name,Product Description,Stock,Cost in GBP,Discontinued
         */
        return [
            [
                $uniq() . ";TV;32” Tv;$lessThan10;$lessThanFiveDollars;\n" .
                $uniq() . ";TV;32” Tv;$lessThan10;$exactFiveDollars;\n" .
                $uniq() . ";TV;32” Tv;$lessThan10;$moreThanFiveDollars;\n" .

                $uniq() . ";TV;32” Tv;$lessThan10;$lessThanThousandDollars;\n" .
                $uniq() . ";TV;32” Tv;$lessThan10;$exactThousandDollars;\n" .
                $uniq() . ";TV;32” Tv;$lessThan10;$moreThanThousandDollars;\n",

                4,
                2,
                "less than 10 block",
            ],
            [
                $uniq() . ";TV;32” Tv;$exact10;$lessThanFiveDollars;\n" .
                $uniq() . ";TV;32” Tv;$exact10;$exactFiveDollars;\n" .
                $uniq() . ";TV;32” Tv;$exact10;$moreThanFiveDollars;\n" .

                $uniq() . ";TV;32” Tv;$exact10;$lessThanThousandDollars;\n" .
                $uniq() . ";TV;32” Tv;$exact10;$exactThousandDollars;\n" .
                $uniq() . ";TV;32” Tv;$exact10;$moreThanThousandDollars;\n",

                5,
                1,
                "exact 10 block",
            ],
            [
                $uniq() . ";TV;32” Tv;$moreThan10;$lessThanFiveDollars;\n" .
                $uniq() . ";TV;32” Tv;$moreThan10;$exactFiveDollars;\n" .
                $uniq() . ";TV;32” Tv;$moreThan10;$moreThanFiveDollars;\n" .

                $uniq() . ";TV;32” Tv;$moreThan10;$lessThanThousandDollars;\n" .
                $uniq() . ";TV;32” Tv;$moreThan10;$exactThousandDollars;\n" .
                $uniq() . ";TV;32” Tv;$moreThan10;$moreThanThousandDollars;\n",

                5,
                1,
                "more than 10 block",
            ],
            [
                $uniq() . ";TV;32” Tv;$lessThan10;$lessThanFiveDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$lessThan10;$exactFiveDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$lessThan10;$moreThanFiveDollars;$haveDiscounted\n" .

                $uniq() . ";TV;32” Tv;$lessThan10;$lessThanThousandDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$lessThan10;$exactThousandDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$lessThan10;$moreThanThousandDollars;$haveDiscounted\n",

                6,
                0,
                "less than 10, have discounted block",
            ],
            [
                $uniq() . ";TV;32” Tv;$exact10;$lessThanFiveDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$exact10;$exactFiveDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$exact10;$moreThanFiveDollars;$haveDiscounted\n" .

                $uniq() . ";TV;32” Tv;$exact10;$lessThanThousandDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$exact10;$exactThousandDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$exact10;$moreThanThousandDollars;$haveDiscounted\n",

                6,
                0,
                "exact 10, have discounted block",
            ],
            [
                $uniq() . ";TV;32” Tv;$moreThan10;$lessThanFiveDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$moreThan10;$exactFiveDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$moreThan10;$moreThanFiveDollars;$haveDiscounted\n" .

                $uniq() . ";TV;32” Tv;$moreThan10;$lessThanThousandDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$moreThan10;$exactThousandDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$moreThan10;$moreThanThousandDollars;$haveDiscounted\n",

                6,
                0,
                "more than 10, have discounted block",
            ],
            [
                $uniq() . ";TV;32” Tv;$corrupted;$lessThanFiveDollars;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$moreThan10;$corrupted;$haveDiscounted\n" .
                $uniq() . ";TV;32” Tv;$moreThan10;$moreThanFiveDollars;$corrupted\n" .

                $uniq() . ";$empty;32” Tv;$moreThan10;$lessThanThousandDollars;$haveDiscounted\n" .
                $uniq() . ";TV;$empty;$moreThan10;$exactThousandDollars;$haveDiscounted\n" .
                $noUniqueSecondTime . ";TV;32” Tv;$moreThan10;$moreThanThousandDollars;$haveDiscounted\n" .
                $noUniqueSecondTime . ";TV;32” Tv;$moreThan10;$moreThanThousandDollars;$haveDiscounted\n".
                $uniq() . ";A;B\n",
                1,
                7,
                "corrupted block",
            ],
        ];
    }

    protected function getCurrencyMock(): Currency
    {
        return new Currency($this->getExchangeMockOneToOneConvert(), new Runtime());
    }

    protected function getExchangeMockOneToOneConvert(): ExchangeInterface
    {
        return new class extends ExchangeAbstract implements ExchangeInterface
        {

            public function get($code)
            {
                return 1;
            }
        };
    }

}