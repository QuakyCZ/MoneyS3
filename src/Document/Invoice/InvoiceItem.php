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

    /** @var Element<string> */
    private Element $vatRate;

    /** @var Element<string> */
    private Element $price;

    /** @var Element<ItemVatSummary> */
    private Element $vatSummary;

    /** @var Element<string> */
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
    }

    public function setDescription(string $description): self
    {
        $this->description->setValue($description);
        return $this;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity->setValue($quantity);
        return $this;
    }

    public function setVatRate(string $vatRate): self
    {
        $this->vatRate->setValue($vatRate);
        return $this;
    }

    public function setPrice(string $price): self
    {
        $this->price->setValue($price);
        return $this;
    }

    public function setVatSummary(ItemVatSummary $vatSummary): self
    {
        $this->vatSummary->setValue($vatSummary);
        return $this;
    }

    public function setPriceType(string $priceType): self
    {
        $this->priceType->setValue($priceType);
        return $this;
    }

    public function setDiscount(string $discount): self
    {
        $this->discount->setValue($discount);
        return $this;
    }

    public function setOrder(string $order): self
    {
        $this->order->setValue($order);
        return $this;
    }

    public function setCurrencies(string $currencies): self
    {
        $this->currencies->setValue($currencies);
        return $this;
    }

    public function setNonStockItem(NonStockItem $nonStockItem): self
    {
        $this->nonStockItem->setValue($nonStockItem);
        return $this;
    }

    public function setPriceAfterDiscount(string $priceAfterDiscount): self
    {
        $this->priceAfterDiscount->setValue($priceAfterDiscount);
        return $this;
    }

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
    }
}
