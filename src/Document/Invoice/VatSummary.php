<?php

namespace eProduct\MoneyS3\Document\Invoice;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class VatSummary implements ISerializable
{
    /** @var Element<float> */
    private Element $base0;

    /** @var Element<float> */
    private Element $base5;

    /** @var Element<float> */
    private Element $base22;

    /** @var Element<float> */
    private Element $vat5;

    /** @var Element<float> */
    private Element $vat22;

    /**
     * Constructor for VatSummary class
     * 
     * @param float|null $base0 Base amount for 0% VAT rate
     * @param float|null $base5 Base amount for lower VAT rate  
     * @param float|null $base22 Base amount for higher VAT rate
     * @param float|null $vat5 VAT amount for lower rate
     * @param float|null $vat22 VAT amount for higher rate
     */
    public function __construct(
        ?float $base0 = 0,
        ?float $base5 = 0,
        ?float $base22 = 0,
        ?float $vat5 = 0,
        ?float $vat22 = 0,
    )
    {
        $this->base0 = new Element("Zaklad0");
        $this->base0->setValue($base0);
        $this->base5 = new Element("Zaklad5");
        $this->base5->setValue($base5);
        $this->base22 = new Element("Zaklad22");
        $this->base22->setValue($base22);
        $this->vat5 = new Element("DPH5");
        $this->vat5->setValue($vat5);
        $this->vat22 = new Element("DPH22");
        $this->vat22->setValue($vat22);
    }

    /**
     * Sets the base amount for 0% VAT rate
     * 
     * @param float $base0 The base amount for 0% VAT
     * @return self Returns this instance for method chaining
     */
    public function setBase0(float $base0): self
    {
        $this->base0->setValue($base0);
        return $this;
    }

    /**
     * Sets the base amount for lower VAT rate
     * 
     * @param float $base5 The base amount for lower VAT
     * @return self Returns this instance for method chaining
     */
    public function setBase5(float $base5): self
    {
        $this->base5->setValue($base5);
        return $this;
    }

    /**
     * Sets the base amount for higher VAT rate
     * 
     * @param float $base22 The base amount for higher VAT
     * @return self Returns this instance for method chaining
     */
    public function setBase22(float $base22): self
    {
        $this->base22->setValue($base22);
        return $this;
    }

    /**
     * Sets the VAT amount for lower rate
     * 
     * @param float $vat5 The VAT amount for lower rate
     * @return self Returns this instance for method chaining
     */
    public function setVat5(float $vat5): self
    {
        $this->vat5->setValue($vat5);
        return $this;
    }

    /**
     * Sets the VAT amount for higher rate
     * 
     * @param float $vat22 The VAT amount for higher rate
     * @return self Returns this instance for method chaining
     */
    public function setVat22(float $vat22): self
    {
        $this->vat22->setValue($vat22);
        return $this;
    }

    /**
     * Serializes the VAT summary to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $this->base0->serialize($writer);
        $this->base5->serialize($writer);
        $this->base22->serialize($writer);
        $this->vat5->serialize($writer);
        $this->vat22->serialize($writer);
    }
}
