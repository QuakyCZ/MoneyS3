<?php

namespace eProduct\MoneyS3\Document\Invoice;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class NonStockItem implements ISerializable
{
    /** @var Element<string> */
    private Element $deposit;

    /** @var Element<string> */
    private Element $periodType;

    /** @var Element<string> */
    private Element $period;

    /** @var Element<string> */
    private Element $counterEntry;

    /** @var Element<string> */
    private Element $weight;

    /**
     * Constructor for NonStockItem class
     * Initializes all non-stock item elements
     */
    public function __construct()
    {
        $this->deposit = new Element("Zaloha");
        $this->periodType = new Element("TypZarDoby");
        $this->period = new Element("ZarDoba");
        $this->counterEntry = new Element("Protizapis");
        $this->weight = new Element("Hmotnost");
    }

    /**
     * Sets the deposit amount for the non-stock item
     * 
     * @param string $deposit The deposit amount
     * @return self Returns this instance for method chaining
     */
    public function setDeposit(string $deposit): self
    {
        $this->deposit->setValue($deposit);
        return $this;
    }

    /**
     * Sets the period type for the non-stock item
     * 
     * @param string $periodType The period type
     * @return self Returns this instance for method chaining
     */
    public function setPeriodType(string $periodType): self
    {
        $this->periodType->setValue($periodType);
        return $this;
    }

    /**
     * Sets the period for the non-stock item
     * 
     * @param string $period The period value
     * @return self Returns this instance for method chaining
     */
    public function setPeriod(string $period): self
    {
        $this->period->setValue($period);
        return $this;
    }

    /**
     * Sets the counter entry for the non-stock item
     * 
     * @param string $counterEntry The counter entry value
     * @return self Returns this instance for method chaining
     */
    public function setCounterEntry(string $counterEntry): self
    {
        $this->counterEntry->setValue($counterEntry);
        return $this;
    }

    /**
     * Sets the weight of the non-stock item
     * 
     * @param string $weight The weight value
     * @return self Returns this instance for method chaining
     */
    public function setWeight(string $weight): self
    {
        $this->weight->setValue($weight);
        return $this;
    }

    /**
     * Serializes the non-stock item to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $this->deposit->serialize($writer);
        $this->periodType->serialize($writer);
        $this->period->serialize($writer);
        $this->counterEntry->serialize($writer);
        $this->weight->serialize($writer);
    }
}
