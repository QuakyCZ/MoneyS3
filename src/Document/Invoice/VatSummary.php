<?php

namespace eProduct\MoneyS3\Document\Invoice;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class VatSummary implements ISerializable
{
    /** @var Element<string> */
    private Element $base0;

    /** @var Element<string> */
    private Element $base5;

    /** @var Element<string> */
    private Element $base22;

    /** @var Element<string> */
    private Element $vat5;

    /** @var Element<string> */
    private Element $vat22;

    public function __construct()
    {
        $this->base0 = new Element("Zaklad0");
        $this->base5 = new Element("Zaklad5");
        $this->base22 = new Element("Zaklad22");
        $this->vat5 = new Element("DPH5");
        $this->vat22 = new Element("DPH22");
    }

    public function setBase0(string $base0): self
    {
        $this->base0->setValue($base0);
        return $this;
    }

    public function setBase5(string $base5): self
    {
        $this->base5->setValue($base5);
        return $this;
    }

    public function setBase22(string $base22): self
    {
        $this->base22->setValue($base22);
        return $this;
    }

    public function setVat5(string $vat5): self
    {
        $this->vat5->setValue($vat5);
        return $this;
    }

    public function setVat22(string $vat22): self
    {
        $this->vat22->setValue($vat22);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $this->base0->serialize($writer);
        $this->base5->serialize($writer);
        $this->base22->serialize($writer);
        $this->vat5->serialize($writer);
        $this->vat22->serialize($writer);
    }
}
