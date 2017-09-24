<?php

namespace Shov\StocksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="Shov\StocksBundle\Repository\StockRepository")
 */
class Stock
{
    /**
     * @var int
     *
     * @ORM\Column(name="intProductDataId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $intProductDataId;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductName", type="string", length=50)
     */
    private $strProductName;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductDesc", type="string", length=255)
     */
    private $strProductDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductCode", type="string", length=10, unique=true)
     */
    private $strProductCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true, options={"default":NULL})
     */
    private $dtmAdded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true, options={"default":NULL})
     */
    private $dtmDiscontinued;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stmTimestamp", type="datetime", columnDefinition="timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
     *
     */
    private $stmTimestamp;

    /**
     * @var int
     * @ORM\Column(name="stockLevel", type="integer")
     */
    private $stockLevel;

    /**
     * @var int
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * Get intProductDataId
     *
     * @return int
     */
    public function getIntProductDataId()
    {
        return $this->intProductDataId;
    }

    /**
     * Set strProductName
     *
     * @param string $strProductName
     *
     * @return Stock
     */
    public function setStrProductName($strProductName)
    {
        $this->strProductName = $strProductName;

        return $this;
    }

    /**
     * Get strProductName
     *
     * @return string
     */
    public function getStrProductName()
    {
        return $this->strProductName;
    }

    /**
     * Set strProductDesc
     *
     * @param string $strProductDesc
     *
     * @return Stock
     */
    public function setStrProductDesc($strProductDesc)
    {
        $this->strProductDesc = $strProductDesc;

        return $this;
    }

    /**
     * Get strProductDesc
     *
     * @return string
     */
    public function getStrProductDesc()
    {
        return $this->strProductDesc;
    }

    /**
     * Set strProductCode
     *
     * @param string $strProductCode
     *
     * @return Stock
     */
    public function setStrProductCode($strProductCode)
    {
        $this->strProductCode = $strProductCode;

        return $this;
    }

    /**
     * Get strProductCode
     *
     * @return string
     */
    public function getStrProductCode()
    {
        return $this->strProductCode;
    }

    /**
     * Set dtmAdded
     *
     * @param \DateTime $dtmAdded
     *
     * @return Stock
     */
    public function setDtmAdded($dtmAdded)
    {
        $this->dtmAdded = $dtmAdded;

        return $this;
    }

    /**
     * Get dtmAdded
     *
     * @return \DateTime
     */
    public function getDtmAdded()
    {
        return $this->dtmAdded;
    }

    /**
     * Set dtmDiscontinued
     *
     * @param \DateTime $dtmDiscontinued
     *
     * @return Stock
     */
    public function setDtmDiscontinued($dtmDiscontinued)
    {
        $this->dtmDiscontinued = $dtmDiscontinued;

        return $this;
    }

    /**
     * Get dtmDiscontinued
     *
     * @return \DateTime
     */
    public function getDtmDiscontinued()
    {
        return $this->dtmDiscontinued;
    }

    /**
     * Set stmTimestamp
     *
     * @param \DateTime $stmTimestamp
     *
     * @return Stock
     */
    public function setStmTimestamp($stmTimestamp)
    {
        $this->stmTimestamp = $stmTimestamp;

        return $this;
    }

    /**
     * Get stmTimestamp
     *
     * @return \DateTime
     */
    public function getStmTimestamp()
    {
        return $this->stmTimestamp;
    }

    /**
     * Set stockLevel
     *
     * @param $stockLevel
     *
     * @return Stock
     */
    public function setStockLevel(int $stockLevel): Stock
    {
        $this->stockLevel = $stockLevel;

        return $this;
    }

    /**
     * Get stockLevel
     *
     * @return int
     */
    public function getStockLevel(): int
    {
        return $this->stockLevel;
    }

    /**
     * Set Price
     *
     * @param int $price
     *
     * @return Stock
     */
    public function setPrice(int $price): Stock
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get Price
     *
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }
}

