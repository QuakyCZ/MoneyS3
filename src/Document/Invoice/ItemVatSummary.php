<?php

namespace eProduct\MoneyS3\Document\Invoice;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class ItemVatSummary implements ISerializable
{
    /** @var Element<string> */
    private Element $baseMJ;

    /** @var Element<string> */
    private Element $vatMJ;

    /** @var Element<string> */
    private Element $base;

    /** @var Element<string> */
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

    public function setBaseMJ(?string $baseMJ): self
    {
        $this->baseMJ->setValue($baseMJ);
        return $this;
    }

    public function setVatMJ(?string $vatMJ): self
    {
        $this->vatMJ->setValue($vatMJ);
        return $this;
    }

    public function setBase(?string $base): self
    {
        $this->base->setValue($base);
        return $this;
    }

    public function setVat(?string $vat): self
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
