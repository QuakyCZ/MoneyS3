<?php

namespace eProduct\MoneyS3\Document\Inventory;

use DateTime;
use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class SerialNumber implements ISerializable
{
    /** @var Element<string> */
    private Element $serialNumber;

    /** @var Element<DateTime> */
    private Element $manufacturingDate;

    /** @var Element<string> */
    private Element $barcode;

    /**
     * Constructor for SerialNumber class
     */
    public function __construct()
    {
        $this->serialNumber = new Element("VyrobniCis");
        $this->manufacturingDate = new Element("DatVyr");
        $this->barcode = new Element("CarKod");
    }

    /**
     * Sets the serial number
     * 
     * @param string|null $serialNumber The serial number
     * @return self Returns this instance for method chaining
     */
    public function setSerialNumber(?string $serialNumber): self
    {
        $this->serialNumber->setValue($serialNumber);
        return $this;
    }

    /**
     * Sets the manufacturing date
     * 
     * @param DateTime|null $manufacturingDate The manufacturing date
     * @return self Returns this instance for method chaining
     */
    public function setManufacturingDate(?DateTime $manufacturingDate): self
    {
        $this->manufacturingDate->setValue($manufacturingDate);
        return $this;
    }

    /**
     * Sets the barcode
     * 
     * @param string|null $barcode The barcode (max 20 characters)
     * @return self Returns this instance for method chaining
     */
    public function setBarcode(?string $barcode): self
    {
        $this->barcode->setValue($barcode);
        return $this;
    }

    /**
     * Serializes the serial number to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('VyrobniCislo');

        $this->serialNumber->serialize($writer);
        $this->manufacturingDate->serialize($writer);
        $this->barcode->serialize($writer);

        $writer->endElement();
    }
}
