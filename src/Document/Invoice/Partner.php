<?php

namespace eProduct\MoneyS3\Document\Invoice;

use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class Partner implements ISerializable
{
    /** @var Element<string> */
    private Element $tradeName;

    /** @var Element<Address> */
    private Element $tradeAddress;

    /** @var Element<string> */
    private Element $invoiceName;

    /** @var Element<string> */
    private Element $ico;

    /** @var Element<Address> */
    private Element $invoiceAddress;

    /** @var Element<string> */
    private Element $name;

    /** @var Element<Address> */
    private Element $address;

    /** @var Element<bool> */
    private Element $vatPayer;

    /** @var Element<bool> */
    private Element $physicalPerson;

    public function __construct()
    {
        $this->name = new Element("Nazev", true);
        $this->address = new Element("Adresa", true);
        $this->tradeName = new Element("ObchNazev");
        $this->tradeAddress = new Element("ObchAdresa");
        $this->invoiceName = new Element("FaktNazev");
        $this->ico = new Element("ICO");
        $this->invoiceAddress = new Element("FaktAdresa");
        $this->vatPayer = new Element("PlatceDPH");
        $this->physicalPerson = new Element("FyzOsoba");
    }

    public function setTradeName(string $tradeName): self
    {
        $this->tradeName->setValue($tradeName);
        return $this;
    }

    public function setTradeAddress(Address $address): self
    {
        $this->tradeAddress->setValue($address);
        return $this;
    }

    public function setInvoiceName(string $invoiceName): self
    {
        $this->invoiceName->setValue($invoiceName);
        return $this;
    }

    public function setIco(string $ico): self
    {
        $this->ico->setValue($ico);
        return $this;
    }

    public function setInvoiceAddress(Address $address): self
    {
        $this->invoiceAddress->setValue($address);
        return $this;
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

    public function setVatPayer(bool $vatPayer): self
    {
        $this->vatPayer->setValue($vatPayer);
        return $this;
    }

    public function setPhysicalPerson(bool $physicalPerson): self
    {
        $this->physicalPerson->setValue($physicalPerson);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $this->tradeName->serialize($writer);
        $this->tradeAddress->serialize($writer);
        $this->invoiceName->serialize($writer);
        $this->ico->serialize($writer);
        $this->invoiceAddress->serialize($writer);
        $this->name->serialize($writer);
        $this->address->serialize($writer);
        $this->vatPayer->serialize($writer);
        $this->physicalPerson->serialize($writer);
    }
}
