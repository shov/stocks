<?php

namespace Shov\StocksBundle\Tests;

use Shov\StocksBundle\Tools\Exchange;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class ExchangeTest
 * @package Shov\StocksBundle\Tests
 * @covers Exchange
 */
class ExchangeTest extends TestCase
{
    /**
     * @test
     * @dataProvider convertingDataProvider
     */
    public function converting($src, $reference)
    {

    }

    public function convertingDataProvider()
    {
        return [
            ['2.3', 2.3],
            ['2.8', 2.8],
            [2.3, 2.3],
            [2.8, 2.8],
            ['2', 2.0],
            ['2.0', 2.0],
            [2, 2.0],
            ['2.777', 2.78],
            [2.777, 2.78],
            [-10, -10.0],
        ];
    }
}