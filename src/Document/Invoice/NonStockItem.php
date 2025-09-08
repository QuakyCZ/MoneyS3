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

    public function __construct()
    {
        $this->deposit = new Element("Zaloha");
        $this->periodType = new Element("TypZarDoby");
        $this->period = new Element("ZarDoba");
        $this->counterEntry = new Element("Protizapis");
        $this->weight = new Element("Hmotnost");
    }

    public function setDeposit(string $deposit): self
    {
        $this->deposit->setValue($deposit);
        return $this;
    }

    public function setPeriodType(string $periodType): self
    {
        $this->periodType->setValue($periodType);
        return $this;
    }

    public function setPeriod(string $period): self
    {
        $this->period->setValue($period);
        return $this;
    }

    public function setCounterEntry(string $counterEntry): self
    {
        $this->counterEntry->setValue($counterEntry);
        return $this;
    }

    public function setWeight(string $weight): self
    {
        $this->weight->setValue($weight);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $this->deposit->serialize($writer);
        $this->periodType->serialize($writer);
        $this->period->serialize($writer);
        $this->counterEntry->serialize($writer);
        $this->weight->serialize($writer);
    }
}
