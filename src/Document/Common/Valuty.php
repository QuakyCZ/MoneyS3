<?php

namespace eProduct\MoneyS3\Document\Common;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

/**
 * Valuty class representing foreign currency document information
 * Contains currency details, VAT summary, and total amount in foreign currency
 */
class Valuty implements ISerializable
{
    /** @var Element<Currency> */
    private Element $currency;

    /** @var Element<VatSummary> */
    private Element $vatSummary;

    /** @var Element<float> */
    private Element $total;

    /**
     * Constructor for Valuty class
     *
     * @param Currency $currency Currency information
     * @param VatSummary|null $vatSummary VAT summary in foreign currency
     * @param float|null $total Total amount with VAT in foreign currency
     */
    public function __construct(
        Currency $currency,
        ?VatSummary $vatSummary = null,
        ?float $total = null
    ) {
        $this->currency = new Element("Mena");
        $this->currency->setValue($currency);

        $this->vatSummary = new Element("SouhrnDPH");
        $this->vatSummary->setValue($vatSummary ?? new VatSummary());

        $this->total = new Element("Celkem");
        $this->total->setValue($total);
    }

    /**
     * Sets the currency information
     *
     * @param Currency $currency The currency information
     * @return self Returns this instance for method chaining
     */
    public function setCurrency(Currency $currency): self
    {
        $this->currency->setValue($currency);
        return $this;
    }

    /**
     * Sets the VAT summary in foreign currency
     *
     * @param VatSummary $vatSummary The VAT summary
     * @return self Returns this instance for method chaining
     */
    public function setVatSummary(VatSummary $vatSummary): self
    {
        $this->vatSummary->setValue($vatSummary);
        return $this;
    }

    /**
     * Sets the total amount with VAT in foreign currency
     *
     * @param float|null $total The total amount
     * @return self Returns this instance for method chaining
     */
    public function setTotal(?float $total): self
    {
        $this->total->setValue($total);
        return $this;
    }


    /**
     * Serializes the foreign currency information to XML
     *
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $this->currency->serialize($writer);
        $this->vatSummary->serialize($writer);
        $this->total->serialize($writer);
    }
}
