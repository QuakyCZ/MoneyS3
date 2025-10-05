<?php

namespace eProduct\MoneyS3\Document\Invoice;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class InvoiceItem implements ISerializable
{
    /** @var Element<string> */
    private Element $description;

    /** @var Element<string> */
    private Element $quantity;

    /** @var Element<int> */
    private Element $vatRate;

    /** @var Element<string> */
    private Element $price;

    /** @var Element<ItemVatSummary> */
    private Element $vatSummary;

    /** @var Element<bool> */
    private Element $priceType;

    /** @var Element<string> */
    private Element $discount;

    /** @var Element<string> */
    private Element $order;

    /** @var Element<string> */
    private Element $currencies;

    /** @var Element<NonStockItem> */
    private Element $nonStockItem;

    /** @var Element<string> */
    private Element $priceAfterDiscount;

    /** @var Element<float> */
    private Element $valuty;

    /**
     * Constructor for InvoiceItem class
     * Initializes all invoice item elements
     */
    public function __construct()
    {
        $this->description = new Element("Popis");
        $this->quantity = new Element("PocetMJ");
        $this->vatRate = new Element("SazbaDPH");
        $this->price = new Element("Cena");
        $this->vatSummary = new Element("SouhrnDPH");
        $this->priceType = new Element("CenaTyp");
        $this->discount = new Element("Sleva");
        $this->order = new Element("Poradi");
        $this->currencies = new Element("Valuty");
        $this->nonStockItem = new Element("NesklPolozka");
        $this->priceAfterDiscount = new Element("CenaPoSleve");
        $this->valuty = new Element("Valuty");
    }

    /**
     * Sets the description of the invoice item
     *
     * @param string|null $description The item description
     * @return self Returns this instance for method chaining
     */
    public function setDescription(?string $description): self
    {
        $this->description->setValue($description);
        return $this;
    }

    /**
     * Sets the quantity of the invoice item
     *
     * @param string|null $quantity The quantity
     * @return self Returns this instance for method chaining
     */
    public function setQuantity(?string $quantity): self
    {
        $this->quantity->setValue($quantity);
        return $this;
    }

    /**
     * Sets the VAT rate for the item
     *
     * @param string|null $vatRate The VAT rate
     * @return self Returns this instance for method chaining
     */
    public function setVatRate(?int $vatRate): self
    {
        $this->vatRate->setValue($vatRate);
        return $this;
    }

    /**
     * Sets the price of the item
     *
     * @param string|null $price The item price
     * @return self Returns this instance for method chaining
     */
    public function setPrice(?string $price): self
    {
        $this->price->setValue($price);
        return $this;
    }

    /**
     * Sets the VAT summary for the item
     *
     * @param ItemVatSummary|null $vatSummary The VAT summary object
     * @return self Returns this instance for method chaining
     */
    public function setVatSummary(?ItemVatSummary $vatSummary): self
    {
        $this->vatSummary->setValue($vatSummary);
        return $this;
    }

    /**
     * Sets the price type
     * True - price is with VAT
     * False - price is without VAT
     *
     * @param string|null $priceType The price type
     * @return self Returns this instance for method chaining
     */
    public function setPriceType(?bool $priceType): self
    {
        $this->priceType->setValue($priceType);
        return $this;
    }

    /**
     * Sets the discount amount
     *
     * @param string|null $discount The discount amount
     * @return self Returns this instance for method chaining
     */
    public function setDiscount(?string $discount): self
    {
        $this->discount->setValue($discount);
        return $this;
    }

    /**
     * Sets the order/position of the item
     *
     * @param string|null $order The item order/position
     * @return self Returns this instance for method chaining
     */
    public function setOrder(?string $order): self
    {
        $this->order->setValue($order);
        return $this;
    }

    /**
     * Sets the currencies for the item
     *
     * @param string|null $currencies The currencies information
     * @return self Returns this instance for method chaining
     */
    public function setCurrencies(?string $currencies): self
    {
        $this->currencies->setValue($currencies);
        return $this;
    }

    /**
     * Sets the non-stock item information
     *
     * @param NonStockItem|null $nonStockItem The non-stock item object
     * @return self Returns this instance for method chaining
     */
    public function setNonStockItem(?NonStockItem $nonStockItem): self
    {
        $this->nonStockItem->setValue($nonStockItem);
        return $this;
    }

    /**
     * Sets the price after discount
     *
     * @param string|null $priceAfterDiscount The price after applying discount
     * @return self Returns this instance for method chaining
     */
    public function setPriceAfterDiscount(?string $priceAfterDiscount): self
    {
        $this->priceAfterDiscount->setValue($priceAfterDiscount);
        return $this;
    }

    public function setValuty(?float $valuty): self
    {
        $this->valuty->setValue($valuty);
        return $this;
    }

    /**
     * Serializes the invoice item to XML
     *
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $this->description->serialize($writer);
        $this->quantity->serialize($writer);
        $this->vatRate->serialize($writer);
        $this->price->serialize($writer);
        $this->vatSummary->serialize($writer);
        $this->priceType->serialize($writer);
        $this->discount->serialize($writer);
        $this->order->serialize($writer);
        $this->currencies->serialize($writer);
        $this->nonStockItem->serialize($writer);
        $this->priceAfterDiscount->serialize($writer);
        $this->valuty->serialize($writer);
    }
}
