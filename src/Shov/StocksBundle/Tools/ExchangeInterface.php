<?php

namespace Shov\StocksBundle\Tools;

interface ExchangeInterface
{
    /**
     * Start with this method to set value
     *
     * @param string|float|int $value
     * @return ExchangeInterface
     */
    public function from($value): ExchangeInterface;

    /**
     * Another one way to set set value
     *
     * @param int $value
     * @return ExchangeInterface
     */
    public function fromHundredths(int $value): ExchangeInterface;

    /**
     * Get value in hundredths like a cents
     *
     * @return int
     */
    public function getAsHundredths(): int;

    /**
     * Get the value
     *
     * @return float
     */
    public function get(): float;

    /**
     * Convert stored value from GBP to USD
     *
     * @return ExchangeInterface
     */
    public function GBPtoUSD(): ExchangeInterface;

    /**
     * Convert stored value from USD to GBP
     *
     * @return ExchangeInterface
     */
    public function USDtoGBP(): ExchangeInterface;
}