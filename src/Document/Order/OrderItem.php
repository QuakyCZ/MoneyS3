<?php

namespace eProduct\MoneyS3\Document\Order;

use DateTime;
use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class OrderItem implements ISerializable
{
    /** @var Element<string> */
    private Element $description;

    /** @var Element<string> */
    private Element $note;

    /** @var Element<float> */
    private Element $quantity;

    /** @var Element<float> */
    private Element $remainingQuantity;

    /** @var Element<float> */
    private Element $price;

    /** @var Element<int> */
    private Element $vatRate;

    /** @var Element<int> */
    private Element $priceType;

    /** @var Element<float> */
    private Element $discount;

    /** @var Element<DateTime> */
    private Element $issued;

    /** @var Element<DateTime> */
    private Element $latestDueDate;

    /** @var Element<DateTime> */
    private Element $dueDate;

    /** @var Element<DateTime> */
    private Element $completed;

    /** @var Element<int> */
    private Element $order;

    /** @var Element<string> */
    private Element $center;

    /** @var Element<string> */
    private Element $project;

    /** @var Element<string> */
    private Element $activity;

    /** @var Element<string> */
    private Element $priceLevel;

    /**
     * Constructor for OrderItem class
     */
    public function __construct()
    {
        $this->description = new Element("Popis");
        $this->note = new Element("Poznamka");
        $this->quantity = new Element("PocetMJ");
        $this->remainingQuantity = new Element("ZbyvaMJ");
        $this->price = new Element("Cena");
        $this->vatRate = new Element("SazbaDPH");
        $this->priceType = new Element("TypCeny");
        $this->discount = new Element("Sleva");
        $this->issued = new Element("Vystaveno");
        $this->latestDueDate = new Element("VyriditNej");
        $this->dueDate = new Element("Vyridit_do");
        $this->completed = new Element("Vyrizeno");
        $this->order = new Element("Poradi");
        $this->center = new Element("Stredisko");
        $this->project = new Element("Zakazka");
        $this->activity = new Element("Cinnost");
        $this->priceLevel = new Element("CenovaHlad");
    }

    /**
     * Sets the description of the item
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
     * Sets a note for the item
     * 
     * @param string|null $note The item note
     * @return self Returns this instance for method chaining
     */
    public function setNote(?string $note): self
    {
        $this->note->setValue($note);
        return $this;
    }

    /**
     * Sets the quantity
     * 
     * @param float|null $quantity The item quantity
     * @return self Returns this instance for method chaining
     */
    public function setQuantity(?float $quantity): self
    {
        $this->quantity->setValue($quantity);
        return $this;
    }

    /**
     * Sets the remaining quantity
     * 
     * @param float|null $remainingQuantity The remaining quantity to be processed
     * @return self Returns this instance for method chaining
     */
    public function setRemainingQuantity(?float $remainingQuantity): self
    {
        $this->remainingQuantity->setValue($remainingQuantity);
        return $this;
    }

    /**
     * Sets the price
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
     * @param int|null $priceType The price type (0=without VAT, 1=with VAT, 2=VAT only, 3=base only)
     * @return self Returns this instance for method chaining
     */
    public function setPriceType(?int $priceType): self
    {
        $this->priceType->setValue($priceType);
        return $this;
    }

    /**
     * Sets the discount amount
     * 
     * @param float|null $discount The discount amount
     * @return self Returns this instance for method chaining
     */
    public function setDiscount(?float $discount): self
    {
        $this->discount->setValue($discount);
        return $this;
    }

    /**
     * Sets the issue date
     * 
     * @param DateTime|null $issued The date when item was issued
     * @return self Returns this instance for method chaining
     */
    public function setIssued(?DateTime $issued): self
    {
        $this->issued->setValue($issued);
        return $this;
    }

    /**
     * Sets the latest due date
     * 
     * @param DateTime|null $latestDueDate The latest due date
     * @return self Returns this instance for method chaining
     */
    public function setLatestDueDate(?DateTime $latestDueDate): self
    {
        $this->latestDueDate->setValue($latestDueDate);
        return $this;
    }

    /**
     * Sets the due date
     * 
     * @param DateTime|null $dueDate The due date
     * @return self Returns this instance for method chaining
     */
    public function setDueDate(?DateTime $dueDate): self
    {
        $this->dueDate->setValue($dueDate);
        return $this;
    }

    /**
     * Sets the completion date
     * 
     * @param DateTime|null $completed The completion date
     * @return self Returns this instance for method chaining
     */
    public function setCompleted(?DateTime $completed): self
    {
        $this->completed->setValue($completed);
        return $this;
    }

    /**
     * Sets the order sequence
     * 
     * @param int|null $order The order sequence for printing
     * @return self Returns this instance for method chaining
     */
    public function setOrder(?int $order): self
    {
        $this->order->setValue($order);
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
     * Sets the price level
     * 
     * @param string|null $priceLevel The price level
     * @return self Returns this instance for method chaining
     */
    public function setPriceLevel(?string $priceLevel): self
    {
        $this->priceLevel->setValue($priceLevel);
        return $this;
    }

    /**
     * Serializes the order item to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $this->description->serialize($writer);
        $this->note->serialize($writer);
        $this->quantity->serialize($writer);
        $this->remainingQuantity->serialize($writer);
        $this->price->serialize($writer);
        $this->vatRate->serialize($writer);
        $this->priceType->serialize($writer);
        $this->discount->serialize($writer);
        $this->issued->serialize($writer);
        $this->latestDueDate->serialize($writer);
        $this->dueDate->serialize($writer);
        $this->completed->serialize($writer);
        $this->order->serialize($writer);
        $this->center->serialize($writer);
        $this->project->serialize($writer);
        $this->activity->serialize($writer);
        $this->priceLevel->serialize($writer);
    }
}
