<?php

namespace eProduct\MoneyS3\Document\Invoice;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class ItemVatSummary implements ISerializable
{
    /** @var Element<float> */
    private Element $baseMJ;

    /** @var Element<float> */
    private Element $vatMJ;

    /** @var Element<float> */
    private Element $base;

    /** @var Element<float> */
    private Element $vat;

    /**
     * Constructor for ItemVatSummary class
     * Initializes all VAT summary elements for an item
     */
    public function __construct()
    {
        $this->baseMJ = new Element("Zaklad_MJ");
        $this->vatMJ = new Element("DPH_MJ");
        $this->base = new Element("Zaklad");
        $this->vat = new Element("DPH");
    }

    public function setBaseMJ(?float $baseMJ): self
    {
        $this->baseMJ->setValue($baseMJ);
        return $this;
    }

    public function setVatMJ(?float $vatMJ): self
    {
        $this->vatMJ->setValue($vatMJ);
        return $this;
    }

    public function setBase(?float $base): self
    {
        $this->base->setValue($base);
        return $this;
    }

    public function setVat(?float $vat): self
    {
        $this->vat->setValue($vat);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $this->baseMJ->serialize($writer);
        $this->vatMJ->serialize($writer);
        $this->base->serialize($writer);
        $this->vat->serialize($writer);
    }
}
