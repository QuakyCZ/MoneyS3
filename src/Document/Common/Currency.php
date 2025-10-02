<?php

namespace eProduct\MoneyS3\Document\Common;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

/**
 * Currency class representing menaType from XSD schema
 * Contains currency code, amount and exchange rate information
 */
class Currency implements ISerializable
{
    /** @var Element<string> */
    private Element $code;

    /** @var Element<int> */
    private Element $amount;

    /** @var Element<float> */
    private Element $rate;

    /**
     * Constructor for Currency class
     *
     * @param string|null $code Currency code (e.g., "EUR", "USD")
     * @param int|null $amount Currency amount for the exchange rate
     * @param float|null $rate Exchange rate
     */
    public function __construct() {
        $this->code = new Element("Kod");
        $this->amount = new Element("Mnozstvi");
        $this->rate = new Element("Kurs");
    }

    /**
     * Sets the currency code
     *
     * @param string $code The currency code
     * @return self Returns this instance for method chaining
     */
    public function setCode(string $code): self
    {
        $this->code->setValue($code);
        return $this;
    }

    /**
     * Sets the currency amount for exchange rate calculation
     *
     * @param int $amount The currency amount
     * @return self Returns this instance for method chaining
     */
    public function setAmount(int $amount): self
    {
        $this->amount->setValue($amount);
        return $this;
    }

    /**
     * Sets the exchange rate
     *
     * @param float|null $rate The exchange rate
     * @return self Returns this instance for method chaining
     */
    public function setRate(?float $rate): self
    {
        $this->rate->setValue($rate);
        return $this;
    }



    /**
     * Serializes the currency information to XML
     *
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $this->code->serialize($writer);
        $this->amount->serialize($writer);
        $this->rate->serialize($writer);
    }
}
