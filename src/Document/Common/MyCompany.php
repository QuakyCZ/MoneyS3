<?php

namespace eProduct\MoneyS3\Document\Common;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

/**
 * MyCompany class representing company information in Money S3 documents
 */
class MyCompany implements ISerializable
{
    /** @var Element<string> */
    private Element $name;

    /** @var Address */
    private Address $address;

    /** @var Element<string> */
    private Element $tradeName;

    /** @var Address */
    private Address $tradeAddress;

    /** @var Element<string> */
    private Element $invoiceName;

    /** @var Address */
    private Address $invoiceAddress;

    /** @var Element<string> */
    private Element $phone;

    /** @var Element<string> */
    private Element $fax;

    /** @var Element<string> */
    private Element $mobile;

    /** @var Element<string> */
    private Element $email;

    /** @var Element<string> */
    private Element $website;

    /** @var Element<string> */
    private Element $ico;

    /** @var Element<string> */
    private Element $dic;

    /** @var Element<string> */
    private Element $bank;

    /** @var Element<string> */
    private Element $account;

    /** @var Element<string> */
    private Element $bankCode;

    /** @var Element<string> */
    private Element $partnerCode;

    /** @var Element<bool> */
    private Element $physicalPerson;

    /** @var Element<string> */
    private Element $currencySymbol;

    /** @var Element<string> */
    private Element $currencyCode;

    public function __construct()
    {
        $this->name = new Element('Nazev');
        $this->address = new Address();
        $this->tradeName = new Element('ObchNazev');
        $this->tradeAddress = new Address();
        $this->invoiceName = new Element('FaktNazev');
        $this->invoiceAddress = new Address();
        $this->phone = new Element('Tel');
        $this->fax = new Element('Fax');
        $this->mobile = new Element('Mobil');
        $this->email = new Element('EMail');
        $this->website = new Element('WWW');
        $this->ico = new Element('ICO');
        $this->dic = new Element('DIC');
        $this->bank = new Element('Banka');
        $this->account = new Element('Ucet');
        $this->bankCode = new Element('KodBanky');
        $this->partnerCode = new Element('KodPartn');
        $this->physicalPerson = new Element('FyzOsoba');
        $this->currencySymbol = new Element('MenaSymb');
        $this->currencyCode = new Element('MenaKod');
    }

    /**
     * Set company name
     *
     * @param string|null $name Company name
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name->setValue($name);
        return $this;
    }

    /**
     * Get address
     *
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * Set trade name
     *
     * @param string|null $tradeName Trade name
     * @return self
     */
    public function setTradeName(?string $tradeName): self
    {
        $this->tradeName->setValue($tradeName);
        return $this;
    }

    /**
     * Get trade address
     *
     * @return Address
     */
    public function getTradeAddress(): Address
    {
        return $this->tradeAddress;
    }

    /**
     * Set invoice name
     *
     * @param string|null $invoiceName Invoice name
     * @return self
     */
    public function setInvoiceName(?string $invoiceName): self
    {
        $this->invoiceName->setValue($invoiceName);
        return $this;
    }

    /**
     * Get invoice address
     *
     * @return Address
     */
    public function getInvoiceAddress(): Address
    {
        return $this->invoiceAddress;
    }

    /**
     * Set phone number
     *
     * @param string|null $phone Phone number
     * @return self
     */
    public function setPhone(?string $phone): self
    {
        $this->phone->setValue($phone);
        return $this;
    }

    /**
     * Set fax number
     *
     * @param string|null $fax Fax number
     * @return self
     */
    public function setFax(?string $fax): self
    {
        $this->fax->setValue($fax);
        return $this;
    }

    /**
     * Set mobile number
     *
     * @param string|null $mobile Mobile number
     * @return self
     */
    public function setMobile(?string $mobile): self
    {
        $this->mobile->setValue($mobile);
        return $this;
    }

    /**
     * Set email address
     *
     * @param string|null $email Email address
     * @return self
     */
    public function setEmail(?string $email): self
    {
        $this->email->setValue($email);
        return $this;
    }

    /**
     * Set website URL
     *
     * @param string|null $website Website URL
     * @return self
     */
    public function setWebsite(?string $website): self
    {
        $this->website->setValue($website);
        return $this;
    }

    /**
     * Set ICO (company identification number)
     *
     * @param string|null $ico ICO
     * @return self
     */
    public function setIco(?string $ico): self
    {
        $this->ico->setValue($ico);
        return $this;
    }

    /**
     * Set DIC (tax identification number)
     *
     * @param string|null $dic DIC
     * @return self
     */
    public function setDic(?string $dic): self
    {
        $this->dic->setValue($dic);
        return $this;
    }

    /**
     * Set bank name
     *
     * @param string|null $bank Bank name
     * @return self
     */
    public function setBank(?string $bank): self
    {
        $this->bank->setValue($bank);
        return $this;
    }

    /**
     * Set account number
     *
     * @param string|null $account Account number
     * @return self
     */
    public function setAccount(?string $account): self
    {
        $this->account->setValue($account);
        return $this;
    }

    /**
     * Set bank code
     *
     * @param string|null $bankCode Bank code
     * @return self
     */
    public function setBankCode(?string $bankCode): self
    {
        $this->bankCode->setValue($bankCode);
        return $this;
    }

    /**
     * Set partner code
     *
     * @param string|null $partnerCode Partner code
     * @return self
     */
    public function setPartnerCode(?string $partnerCode): self
    {
        $this->partnerCode->setValue($partnerCode);
        return $this;
    }

    /**
     * Set physical person flag
     *
     * @param bool|null $physicalPerson Physical person flag
     * @return self
     */
    public function setPhysicalPerson(?bool $physicalPerson): self
    {
        $this->physicalPerson->setValue($physicalPerson);
        return $this;
    }

    /**
     * Set currency symbol
     *
     * @param string|null $currencySymbol Currency symbol
     * @return self
     */
    public function setCurrencySymbol(?string $currencySymbol): self
    {
        $this->currencySymbol->setValue($currencySymbol);
        return $this;
    }

    /**
     * Set currency code
     *
     * @param string|null $currencyCode Currency code
     * @return self
     */
    public function setCurrencyCode(?string $currencyCode): self
    {
        $this->currencyCode->setValue($currencyCode);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('MojeFirma');

        $this->name->serialize($writer);

        // Serialize address with custom element name
        if ($this->address->hasValues()) {
            $writer->startElement('Adresa');
            $this->address->serializeContent($writer);
            $writer->endElement();
        }

        $this->tradeName->serialize($writer);

        // Serialize trade address with custom element name
        if ($this->tradeAddress->hasValues()) {
            $writer->startElement('ObchAdresa');
            $this->tradeAddress->serializeContent($writer);
            $writer->endElement();
        }

        $this->invoiceName->serialize($writer);

        // Serialize invoice address with custom element name
        if ($this->invoiceAddress->hasValues()) {
            $writer->startElement('FaktAdresa');
            $this->invoiceAddress->serializeContent($writer);
            $writer->endElement();
        }

        $this->phone->serialize($writer);
        $this->fax->serialize($writer);
        $this->mobile->serialize($writer);
        $this->email->serialize($writer);
        $this->website->serialize($writer);
        $this->ico->serialize($writer);
        $this->dic->serialize($writer);
        $this->bank->serialize($writer);
        $this->account->serialize($writer);
        $this->bankCode->serialize($writer);
        $this->partnerCode->serialize($writer);
        $this->physicalPerson->serialize($writer);
        $this->currencySymbol->serialize($writer);
        $this->currencyCode->serialize($writer);

        $writer->endElement();
    }
}
