<?php

namespace Shov\StocksBundle\Tools;

use Moltin\Currency\Currency;
use Moltin\Currency\Exchange\ExchangeAbstract;
use Moltin\Currency\Format\Runtime;
use Shov\StocksBundle\Exceptions\ExchangeException;

class Exchange implements ExchangeInterface
{
    /**
     * @var Currency
     */
    protected $engine;

    /**
     * Store current value in hundredths (like a cents)
     * @var int
     */
    protected $value = null;

    public function __construct()
    {
        /**
         * For the test project I use here the "mock" of currency exchange, it just convert one to one
         */
        $this->engine = new Currency(new class extends ExchangeAbstract implements \Moltin\Currency\ExchangeInterface
        {
            public function get($code)
            {
                return 1;
            }
        }, new Runtime());
    }

    /**
     * Start with this method to set value
     *
     * @param string|float|int $value
     * @return ExchangeInterface
     * @throws ExchangeException
     */
    public function from($value): ExchangeInterface
    {
        if (!is_numeric($value)) {
            throw new ExchangeException("Wrong currency value!");
        }

        $this->value = $this->fullToHundredths((float)$value);
    }

    /**
     * Another one way to set set value
     *
     * @param int $value
     * @return ExchangeInterface
     */
    public function fromHundredths(int $value): ExchangeInterface
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value in hundredths like a cents
     *
     * @return int
     */
    public function getAsHundredths(): int
    {
        $this->alreadyHaveValue();
        return $this->value;
    }

    /**
     * Get the value
     *
     * @return float
     */
    public function get(): float
    {
        $this->alreadyHaveValue();
        return $this->hundredthsToFull($this->value);
    }

    /**
     * Convert stored value from GBP to USD
     *
     * @return ExchangeInterface
     */
    public function GBPtoUSD(): ExchangeInterface
    {
        $this->alreadyHaveValue();
        $this->value =
            $this->fullToHundredths(
                $this->engine
                    ->convert($this->hundredthsToFull($this->value))
                    ->from('GBP')
                    ->to('USD')
                    ->value()
            );

        return $this;
    }

    /**
     * Convert stored value from USD to GBP
     *
     * @return ExchangeInterface
     */
    public function USDtoGBP(): ExchangeInterface
    {
        $this->alreadyHaveValue();
        $this->value =
            $this->fullToHundredths(
                $this->engine
                    ->convert($this->hundredthsToFull($this->value))
                    ->from('USD')
                    ->to('GBP')
                    ->value()
            );

        return $this;
    }

    /**
     * Check we have already set the value
     *
     * @throws ExchangeException
     */
    protected function alreadyHaveValue()
    {
        if (is_null($this->value) || !is_int($this->value)) {
            throw new ExchangeException("Set the value firstly!");
        }
    }

    /**
     * Make full float value from hundredths
     *
     * @param int $src
     * @return float
     */
    protected function hundredthsToFull(int $src): float
    {
        return round($src / 100, 2);
    }

    /**
     * Make from full value the hundredths
     *
     * @param float $src
     * @return int
     */
    protected function fullToHundredths(float $src): int
    {
        return round($src, 2) * 100;
    }
}