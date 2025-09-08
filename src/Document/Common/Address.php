<?php

namespace eProduct\MoneyS3\Document\Common;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class Address implements ISerializable
{

    /** @var Element<string>  */
    private Element $street;

    /** @var Element<string>  */
    private Element $city;

    /** @var Element<string> */
    private Element $postalCode;

    /** @var Element<string> */
    private Element $country;

    /** @var Element<string> */
    private Element $countryCode;
    public function __construct()
    {
        $this->street = new Element("Ulice");
        $this->city = new Element("Misto");
        $this->postalCode = new Element("PSC");
        $this->country = new Element("Stat");
        $this->countryCode = new Element("KodStatu");
    }

    public function setStreet(string $street): self
    {
        $this->street->setValue($street);
        return $this;
    }

    public function setCity(string $city): self
    {
        $this->city->setValue($city);
        return $this;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode->setValue($postalCode);
        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->country->setValue($country);
        return $this;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode->setValue($countryCode);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $this->street->serialize($writer);
        $this->city->serialize($writer);
        $this->postalCode->serialize($writer);
        $this->country->serialize($writer);
        $this->countryCode->serialize($writer);
    }
}