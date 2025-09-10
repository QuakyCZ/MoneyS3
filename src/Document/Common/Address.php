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

    /**
     * Constructor for Address class
     * Initializes all address-related elements
     */
    public function __construct()
    {
        $this->street = new Element("Ulice");
        $this->city = new Element("Misto");
        $this->postalCode = new Element("PSC");
        $this->country = new Element("Stat");
        $this->countryCode = new Element("KodStatu");
    }

    /**
     * Sets the street address
     *
     * @param string|null $street The street address
     * @return self Returns this instance for method chaining
     */
    public function setStreet(?string $street): self
    {
        $this->street->setValue($street);
        return $this;
    }

    /**
     * Sets the city name
     *
     * @param string|null $city The city name
     * @return self Returns this instance for method chaining
     */
    public function setCity(?string $city): self
    {
        $this->city->setValue($city);
        return $this;
    }

    /**
     * Sets the postal code
     *
     * @param string|null $postalCode The postal code
     * @return self Returns this instance for method chaining
     */
    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode->setValue($postalCode);
        return $this;
    }

    /**
     * Sets the country name
     *
     * @param string|null $country The country name
     * @return self Returns this instance for method chaining
     */
    public function setCountry(?string $country): self
    {
        $this->country->setValue($country);
        return $this;
    }

    /**
     * Sets the country code
     *
     * @param string|null $countryCode The country code (e.g., "CZ", "SK", "DE")
     * @return self Returns this instance for method chaining
     */
    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode->setValue($countryCode);
        return $this;
    }

    /**
     * Serializes the address to XML
     *
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $this->street->serialize($writer);
        $this->city->serialize($writer);
        $this->postalCode->serialize($writer);
        $this->country->serialize($writer);
        $this->countryCode->serialize($writer);
    }
}
