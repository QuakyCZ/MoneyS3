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

    /**
     * Constructor for Company class
     * Initializes all company-related elements for invoice
     */
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

    /**
     * Sets the company name for invoicing
     *
     * @param string|null $invoiceName The company name
     * @return self Returns this instance for method chaining
     */
    public function setInvoiceName(?string $invoiceName): self
    {
        $this->invoiceName->setValue($invoiceName);
        return $this;
    }

    /**
     * Sets the company address for invoicing
     *
     * @param Address|null $address The company address
     * @return self Returns this instance for method chaining
     */
    public function setInvoiceAddress(?Address $address): self
    {
        $this->invoiceAddress->setValue($address);
        return $this;
    }

    /**
     * Sets the company identification number (ICO)
     *
     * @param string|null $ico The company identification number
     * @return self Returns this instance for method chaining
     */
    public function setIco(?string $ico): self
    {
        $this->ico->setValue($ico);
        return $this;
    }

    /**
     * Sets the VAT identification number (DIC)
     *
     * @param string|null $dic The VAT identification number
     * @return self Returns this instance for method chaining
     */
    public function setDic(?string $dic): self
    {
        $this->dic->setValue($dic);
        return $this;
    }

    /**
     * Sets whether the company is a physical person
     *
     * @param bool|null $physicalPerson True if physical person, false if legal entity
     * @return self Returns this instance for method chaining
     */
    public function setPhysicalPerson(?bool $physicalPerson): self
    {
        $this->physicalPerson->setValue($physicalPerson);
        return $this;
    }

    /**
     * Sets the currency symbol
     *
     * @param string|null $currencySymbol The currency symbol (e.g., "Kč", "€", "$")
     * @return self Returns this instance for method chaining
     */
    public function setCurrencySymbol(?string $currencySymbol): self
    {
        $this->currencySymbol->setValue($currencySymbol);
        return $this;
    }

    /**
     * Sets the currency code
     *
     * @param string|null $currencyCode The currency code (e.g., "CZK", "EUR", "USD")
     * @return self Returns this instance for method chaining
     */
    public function setCurrencyCode(?string $currencyCode): self
    {
        $this->currencyCode->setValue($currencyCode);
        return $this;
    }

    /**
     * Serializes the company data to XML
     *
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
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
