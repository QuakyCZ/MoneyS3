<?php

namespace eProduct\MoneyS3\Document\Invoice;

use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class FinalRecipient implements ISerializable
{
    /** @var Element<string> */
    private Element $name;

    /** @var Element<Address> */
    private Element $address;

    /** @var Element<string> */
    private Element $ico;

    /** @var Element<string> */
    private Element $vatPayer;

    /** @var Element<string> */
    private Element $physicalPerson;

    /**
     * Constructor for FinalRecipient class
     * Initializes all final recipient elements
     */
    public function __construct()
    {
        $this->name = new Element("Nazev");
        $this->address = new Element("Adresa");
        $this->ico = new Element("ICO");
        $this->vatPayer = new Element("PlatceDPH");
        $this->physicalPerson = new Element("FyzOsoba");
    }

    /**
     * Sets the name of the final recipient
     * 
     * @param string $name The recipient's name
     * @return self Returns this instance for method chaining
     */
    public function setName(string $name): self
    {
        $this->name->setValue($name);
        return $this;
    }

    /**
     * Sets the address of the final recipient
     * 
     * @param Address $address The recipient's address object
     * @return self Returns this instance for method chaining
     */
    public function setAddress(Address $address): self
    {
        $this->address->setValue($address);
        return $this;
    }

    /**
     * Sets the company identification number (ICO) of the final recipient
     * 
     * @param string $ico The company identification number
     * @return self Returns this instance for method chaining
     */
    public function setIco(string $ico): self
    {
        $this->ico->setValue($ico);
        return $this;
    }

    /**
     * Sets whether the final recipient is a VAT payer
     * 
     * @param string $vatPayer The VAT payer status
     * @return self Returns this instance for method chaining
     */
    public function setVatPayer(string $vatPayer): self
    {
        $this->vatPayer->setValue($vatPayer);
        return $this;
    }

    /**
     * Sets whether the final recipient is a physical person
     * 
     * @param string $physicalPerson The physical person status
     * @return self Returns this instance for method chaining
     */
    public function setPhysicalPerson(string $physicalPerson): self
    {
        $this->physicalPerson->setValue($physicalPerson);
        return $this;
    }

    /**
     * Serializes the final recipient to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $this->name->serialize($writer);
        $this->address->serialize($writer);
        $this->ico->serialize($writer);
        $this->vatPayer->serialize($writer);
        $this->physicalPerson->serialize($writer);
    }
}
