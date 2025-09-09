<?php

namespace eProduct\MoneyS3\Document\Inventory;

use DateTime;
use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class InventoryItem implements ISerializable
{
    /** @var Element<string> */
    private Element $description;

    /** @var Element<string> */
    private Element $abbreviation;

    /** @var Element<int> */
    private Element $group;

    /** @var Element<string> */
    private Element $unit;

    /** @var Element<float> */
    private Element $quantity;

    /** @var Element<string> */
    private Element $warehouse;

    /** @var Element<string> */
    private Element $stockCard;

    /** @var SerialNumber[] */
    private array $serialNumbers = [];

    /** @var SubItem[] */
    private array $subItems = [];

    /**
     * Constructor for InventoryItem class
     */
    public function __construct()
    {
        $this->description = new Element("Popis");
        $this->abbreviation = new Element("Zkrat");
        $this->group = new Element("Slupina");
        $this->unit = new Element("MJ");
        $this->quantity = new Element("MnInv");
        $this->warehouse = new Element("Sklad");
        $this->stockCard = new Element("KmKarta");
    }

    /**
     * Sets the description
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
     * Sets the abbreviation
     * 
     * @param string|null $abbreviation The item abbreviation (max 50 characters)
     * @return self Returns this instance for method chaining
     */
    public function setAbbreviation(?string $abbreviation): self
    {
        $this->abbreviation->setValue($abbreviation);
        return $this;
    }

    /**
     * Sets the group number
     * 
     * @param int|null $group The group number
     * @return self Returns this instance for method chaining
     */
    public function setGroup(?int $group): self
    {
        $this->group->setValue($group);
        return $this;
    }

    /**
     * Sets the unit
     * 
     * @param string|null $unit The measurement unit
     * @return self Returns this instance for method chaining
     */
    public function setUnit(?string $unit): self
    {
        $this->unit->setValue($unit);
        return $this;
    }

    /**
     * Sets the quantity
     * 
     * @param float|null $quantity The quantity in the measurement unit
     * @return self Returns this instance for method chaining
     */
    public function setQuantity(?float $quantity): self
    {
        $this->quantity->setValue($quantity);
        return $this;
    }

    /**
     * Sets the warehouse
     * 
     * @param string|null $warehouse The warehouse identifier
     * @return self Returns this instance for method chaining
     */
    public function setWarehouse(?string $warehouse): self
    {
        $this->warehouse->setValue($warehouse);
        return $this;
    }

    /**
     * Sets the stock card
     * 
     * @param string|null $stockCard The stock card identifier
     * @return self Returns this instance for method chaining
     */
    public function setStockCard(?string $stockCard): self
    {
        $this->stockCard->setValue($stockCard);
        return $this;
    }

    /**
     * Adds a serial number
     * 
     * @param SerialNumber $serialNumber The serial number to add
     * @return self Returns this instance for method chaining
     */
    public function addSerialNumber(SerialNumber $serialNumber): self
    {
        $this->serialNumbers[] = $serialNumber;
        return $this;
    }

    /**
     * Sets all serial numbers
     * 
     * @param SerialNumber[] $serialNumbers The serial numbers to set
     * @return self Returns this instance for method chaining
     */
    public function setSerialNumbers(array $serialNumbers): self
    {
        $this->serialNumbers = $serialNumbers;
        return $this;
    }

    /**
     * Gets all serial numbers
     * 
     * @return SerialNumber[] The serial numbers
     */
    public function getSerialNumbers(): array
    {
        return $this->serialNumbers;
    }

    /**
     * Adds a sub-item (for composite cards)
     * 
     * @param SubItem $subItem The sub-item to add
     * @return self Returns this instance for method chaining
     */
    public function addSubItem(SubItem $subItem): self
    {
        $this->subItems[] = $subItem;
        return $this;
    }

    /**
     * Sets all sub-items
     * 
     * @param SubItem[] $subItems The sub-items to set
     * @return self Returns this instance for method chaining
     */
    public function setSubItems(array $subItems): self
    {
        $this->subItems = $subItems;
        return $this;
    }

    /**
     * Gets all sub-items
     * 
     * @return SubItem[] The sub-items
     */
    public function getSubItems(): array
    {
        return $this->subItems;
    }

    /**
     * Serializes the inventory item to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('Polozka');

        $this->description->serialize($writer);
        $this->abbreviation->serialize($writer);
        $this->group->serialize($writer);
        $this->unit->serialize($writer);
        $this->quantity->serialize($writer);

        // Serial numbers list
        if (!empty($this->serialNumbers)) {
            $writer->startElement('SeznamVC');
            foreach ($this->serialNumbers as $serialNumber) {
                $serialNumber->serialize($writer);
            }
            $writer->endElement();
        }

        $this->warehouse->serialize($writer);
        $this->stockCard->serialize($writer);

        // Sub-items for composite cards
        if (!empty($this->subItems)) {
            $writer->startElement('Slozeni');
            foreach ($this->subItems as $subItem) {
                $subItem->serialize($writer);
            }
            $writer->endElement();
        }

        $writer->endElement();
    }
}
