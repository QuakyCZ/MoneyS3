<?php

namespace eProduct\MoneyS3\Document\Invoice;

use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class Company implements ISerializable
{
    /** @var Element<string> */
    private Element $invoiceName;

    /** @var Element<Address> */
    private Element $invoiceAddress;

    /** @var Element<string> */
    private Element $ico;

    /** @var Element<string> */
    private Element $dic;

    /** @var Element<bool> */
    private Element $physicalPerson;

    /** @var Element<string> */
    private Element $currencySymbol;

    /** @var Element<string> */
    private Element $currencyCode;

    public function __construct()
    {
        $this->invoiceName = new Element("FaktNazev");
        $this->invoiceAddress = new Element("FaktAdresa");
        $this->ico = new Element("ICO");
        $this->dic = new Element("DIC");
        $this->physicalPerson = new Element("FyzOsoba");
        $this->currencySymbol = new Element("MenaSymb");
        $this->currencyCode = new Element("MenaKod");
    }

    public function setInvoiceName(string $invoiceName): self
    {
        $this->invoiceName->setValue($invoiceName);
        return $this;
    }

    public function setInvoiceAddress(Address $address): self
    {
        $this->invoiceAddress->setValue($address);
        return $this;
    }

    public function setIco(string $ico): self
    {
        $this->ico->setValue($ico);
        return $this;
    }

    public function setDic(string $dic): self
    {
        $this->dic->setValue($dic);
        return $this;
    }

    public function setPhysicalPerson(bool $physicalPerson): self
    {
        $this->physicalPerson->setValue($physicalPerson);
        return $this;
    }

    public function setCurrencySymbol(string $currencySymbol): self
    {
        $this->currencySymbol->setValue($currencySymbol);
        return $this;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode->setValue($currencyCode);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $this->invoiceName->serialize($writer);
        $this->invoiceAddress->serialize($writer);
        $this->ico->serialize($writer);
        $this->dic->serialize($writer);
        $this->physicalPerson->serialize($writer);
        $this->currencySymbol->serialize($writer);
        $this->currencyCode->serialize($writer);
    }
}
