<?php

namespace eProduct\MoneyS3\Document\Inventory;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class SubItem implements ISerializable
{
    /** @var Element<float> */
    private Element $quantity;

    /** @var InventoryItem */
    private InventoryItem $item;

    /**
     * Constructor for SubItem class
     * 
     * @param InventoryItem $item The inventory item
     */
    public function __construct(InventoryItem $item)
    {
        $this->quantity = new Element("MnSada", true);
        $this->item = $item;
    }

    /**
     * Sets the quantity per set
     * 
     * @param float|null $quantity The quantity per set (must be greater than 0)
     * @return self Returns this instance for method chaining
     */
    public function setQuantity(?float $quantity): self
    {
        $this->quantity->setValue($quantity);
        return $this;
    }

    /**
     * Gets the inventory item
     * 
     * @return InventoryItem The inventory item
     */
    public function getItem(): InventoryItem
    {
        return $this->item;
    }

    /**
     * Serializes the sub-item to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('SubPolozka');

        $this->quantity->serialize($writer);
        $this->item->serialize($writer);

        $writer->endElement();
    }
}
