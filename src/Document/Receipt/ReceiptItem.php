<?php

namespace eProduct\MoneyS3\Document\Receipt;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

/**
 * Receipt item class for Money S3 receipt documents
 * Represents a single item/line in a receipt
 */
class ReceiptItem implements ISerializable
{
    /** @var Element<int> */
    private Element $order;

    /** @var Element<string> */
    private Element $description;

    /** @var Element<float> */
    private Element $price;

    /** @var Element<float> */
    private Element $currencies;

    /** @var Element<int> */
    private Element $priceType;

    /** @var Element<float> */
    private Element $vatRate;

    /** @var Element<float> */
    private Element $quantity;

    public function __construct()
    {
        $this->order = new Element('Poradi');
        $this->description = new Element('Popis');
        $this->price = new Element('Cena');
        $this->currencies = new Element('Valuty');
        $this->priceType = new Element('CenaTyp');
        $this->vatRate = new Element('SazbaDPH');
        $this->quantity = new Element('PocetMJ');
    }

    /**
     * Set the order/position of the item
     *
     * @param int|null $order Item order/position
     * @return self
     */
    public function setOrder(?int $order): self
    {
        $this->order->setValue($order);
        return $this;
    }

    /**
     * Set item description
     *
     * @param string|null $description Item description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description->setValue($description);
        return $this;
    }

    /**
     * Set item price
     *
     * @param float|null $price Item price
     * @return self
     */
    public function setPrice(?float $price): self
    {
        $this->price->setValue($price);
        return $this;
    }

    /**
     * Set currencies value
     *
     * @param float|null $currencies Currencies value
     * @return self
     */
    public function setCurrencies(?float $currencies): self
    {
        $this->currencies->setValue($currencies);
        return $this;
    }

    /**
     * Set price type
     * 0 = bez DPH, 1 = s DPH, 2 = jen DPH, 3 = jen základ, 4 = s DPH
     *
     * @param int|null $priceType Price type
     * @return self
     */
    public function setPriceType(?int $priceType): self
    {
        $this->priceType->setValue($priceType);
        return $this;
    }

    /**
     * Set VAT rate
     *
     * @param float|null $vatRate VAT rate percentage
     * @return self
     */
    public function setVatRate(?float $vatRate): self
    {
        $this->vatRate->setValue($vatRate);
        return $this;
    }

    /**
     * Set quantity
     *
     * @param float|null $quantity Item quantity
     * @return self
     */
    public function setQuantity(?float $quantity): self
    {
        $this->quantity->setValue($quantity);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('NormPolozka');
        $this->order->serialize($writer);
        $this->description->serialize($writer);
        $this->price->serialize($writer);
        $this->currencies->serialize($writer);
        $this->priceType->serialize($writer);
        $this->vatRate->serialize($writer);
        $this->quantity->serialize($writer);
        $writer->endElement();
    }
}
