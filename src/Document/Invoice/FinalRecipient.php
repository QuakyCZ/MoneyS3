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

    public function __construct()
    {
        $this->name = new Element("Nazev");
        $this->address = new Element("Adresa");
        $this->ico = new Element("ICO");
        $this->vatPayer = new Element("PlatceDPH");
        $this->physicalPerson = new Element("FyzOsoba");
    }

    public function setName(string $name): self
    {
        $this->name->setValue($name);
        return $this;
    }

    public function setAddress(Address $address): self
    {
        $this->address->setValue($address);
        return $this;
    }

    public function setIco(string $ico): self
    {
        $this->ico->setValue($ico);
        return $this;
    }

    public function setVatPayer(string $vatPayer): self
    {
        $this->vatPayer->setValue($vatPayer);
        return $this;
    }

    public function setPhysicalPerson(string $physicalPerson): self
    {
        $this->physicalPerson->setValue($physicalPerson);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $this->name->serialize($writer);
        $this->address->serialize($writer);
        $this->ico->serialize($writer);
        $this->vatPayer->serialize($writer);
        $this->physicalPerson->serialize($writer);
    }
}
