<?php

namespace eProduct\MoneyS3\Document\Warehouse;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class WarehouseItem implements ISerializable
{
    /** @var Element<string> */
    private Element $name;

    /** @var Element<float> */
    private Element $quantity;

    /** @var Element<float> */
    private Element $price;

    /** @var Element<float> */
    private Element $foreignCurrencyAmount;

    /** @var Element<int> */
    private Element $vatRate;

    /** @var Element<int> */
    private Element $priceType;

    /** @var Element<float> */
    private Element $discount;

    /** @var Element<string> */
    private Element $activity;

    /** @var Element<string> */
    private Element $project;

    /** @var Element<string> */
    private Element $center;

    /**
     * Constructor for WarehouseItem class
     */
    public function __construct()
    {
        $this->name = new Element("Nazev");
        $this->quantity = new Element("PocetMJ");
        $this->price = new Element("Cena");
        $this->foreignCurrencyAmount = new Element("Valuty");
        $this->vatRate = new Element("DPH");
        $this->priceType = new Element("CenaTyp");
        $this->discount = new Element("Sleva");
        $this->activity = new Element("Cinnost");
        $this->project = new Element("Zakazka");
        $this->center = new Element("Stredisko");
    }

    /**
     * Sets the item name/description
     * 
     * @param string|null $name The item name
     * @return self Returns this instance for method chaining
     */
    public function setName(?string $name): self
    {
        $this->name->setValue($name);
        return $this;
    }

    /**
     * Sets the quantity
     * 
     * @param float|null $quantity The quantity in measurement units
     * @return self Returns this instance for method chaining
     */
    public function setQuantity(?float $quantity): self
    {
        $this->quantity->setValue($quantity);
        return $this;
    }

    /**
     * Sets the price
     * For receipts: purchase price. For issues: delivery note and sales receipt - sales price, issue - acquisition price by default.
     * 
     * @param float|null $price The item price
     * @return self Returns this instance for method chaining
     */
    public function setPrice(?float $price): self
    {
        $this->price->setValue($price);
        return $this;
    }

    /**
     * Sets the amount in foreign currency
     * 
     * @param float|null $foreignCurrencyAmount The amount in foreign currency
     * @return self Returns this instance for method chaining
     */
    public function setForeignCurrencyAmount(?float $foreignCurrencyAmount): self
    {
        $this->foreignCurrencyAmount->setValue($foreignCurrencyAmount);
        return $this;
    }

    /**
     * Sets the VAT rate
     * 
     * @param int|null $vatRate The VAT rate in percentage
     * @return self Returns this instance for method chaining
     */
    public function setVatRate(?int $vatRate): self
    {
        $this->vatRate->setValue($vatRate);
        return $this;
    }

    /**
     * Sets the price type
     * 
     * @param int|null $priceType The price type (0=without VAT, 1=with VAT, etc.)
     * @return self Returns this instance for method chaining
     */
    public function setPriceType(?int $priceType): self
    {
        $this->priceType->setValue($priceType);
        return $this;
    }

    /**
     * Sets the item discount
     * 
     * @param float|null $discount The discount amount for this item
     * @return self Returns this instance for method chaining
     */
    public function setDiscount(?float $discount): self
    {
        $this->discount->setValue($discount);
        return $this;
    }

    /**
     * Sets the activity
     * 
     * @param string|null $activity The activity code
     * @return self Returns this instance for method chaining
     */
    public function setActivity(?string $activity): self
    {
        $this->activity->setValue($activity);
        return $this;
    }

    /**
     * Sets the project
     * 
     * @param string|null $project The project code
     * @return self Returns this instance for method chaining
     */
    public function setProject(?string $project): self
    {
        $this->project->setValue($project);
        return $this;
    }

    /**
     * Sets the center/cost center
     * 
     * @param string|null $center The center code
     * @return self Returns this instance for method chaining
     */
    public function setCenter(?string $center): self
    {
        $this->center->setValue($center);
        return $this;
    }

    /**
     * Serializes the warehouse item to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $this->name->serialize($writer);
        $this->quantity->serialize($writer);
        $this->price->serialize($writer);
        $this->foreignCurrencyAmount->serialize($writer);
        $this->vatRate->serialize($writer);
        $this->priceType->serialize($writer);
        $this->discount->serialize($writer);
        $this->activity->serialize($writer);
        $this->project->serialize($writer);
        $this->center->serialize($writer);
    }
}
