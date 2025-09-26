<?php


namespace eProduct\MoneyS3\Document\Common;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

/**
 * PhoneTax contact information
 */
class PhoneTax implements ISerializable
{
    /** @var Element<string> */
    private Element $prefix;

    /** @var Element<string> */
    private Element $number;

    /** @var Element<string> */
    private Element $extension;

    public function __construct()
    {
        $this->prefix = new Element('Pred');
        $this->number = new Element('Cislo');
        $this->extension = new Element('Klap');
    }

    /**
     * Set phone prefix (area code)
     */
    public function setPrefix(string $prefix): self
    {
        $this->prefix->setValue($prefix);
        return $this;
    }

    /**
     * Set phone number
     */
    public function setNumber(string $number): self
    {
        $this->number->setValue($number);
        return $this;
    }

    /**
     * Set phone extension
     */
    public function setExtension(string $extension): self
    {
        $this->extension->setValue($extension);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $this->prefix->serialize($writer);
        $this->number->serialize($writer);
        $this->extension->serialize($writer);
    }
}