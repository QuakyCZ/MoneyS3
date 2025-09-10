<?php

namespace eProduct\MoneyS3\Document\Inventory;

use eProduct\MoneyS3\Document\IDocument;
use eProduct\MoneyS3\Element;
use XMLWriter;

class InventoryDocument implements IDocument
{
    /** @var Element<int> */
    private Element $documentNumber;

    /** @var Element<int> */
    private Element $inventoryId;

    /** @var Element<string> */
    private Element $description;

    /** @var Element<string> */
    private Element $worker;

    /** @var Element<string> */
    private Element $controller;

    /** @var Element<string> */
    private Element $note;

    /** @var InventoryItem[] */
    private array $items = [];

    /**
     * Constructor for InventoryDocument class
     */
    public function __construct()
    {
        $this->documentNumber = new Element("CisloD", true);
        $this->inventoryId = new Element("InvID", true);
        $this->description = new Element("Popis");
        $this->worker = new Element("Prac");
        $this->controller = new Element("Kontr");
        $this->note = new Element("Poznamka");
    }

    /**
     * Sets the document number
     *
     * @param int|null $documentNumber The document number within the inventory
     * @return self Returns this instance for method chaining
     */
    public function setDocumentNumber(?int $documentNumber): self
    {
        $this->documentNumber->setValue($documentNumber);
        return $this;
    }

    /**
     * Sets the inventory ID
     *
     * @param int|null $inventoryId The inventory line number, together with documentNumber makes unique identifier
     * @return self Returns this instance for method chaining
     */
    public function setInventoryId(?int $inventoryId): self
    {
        $this->inventoryId->setValue($inventoryId);
        return $this;
    }

    /**
     * Sets the description
     *
     * @param string|null $description The document description (max 50 characters)
     * @return self Returns this instance for method chaining
     */
    public function setDescription(?string $description): self
    {
        $this->description->setValue($description);
        return $this;
    }

    /**
     * Sets the worker
     *
     * @param string|null $worker The worker who performed the inventory (max 50 characters)
     * @return self Returns this instance for method chaining
     */
    public function setWorker(?string $worker): self
    {
        $this->worker->setValue($worker);
        return $this;
    }

    /**
     * Sets the controller
     *
     * @param string|null $controller The person who controlled the inventory (max 50 characters)
     * @return self Returns this instance for method chaining
     */
    public function setController(?string $controller): self
    {
        $this->controller->setValue($controller);
        return $this;
    }

    /**
     * Sets a note
     *
     * @param string|null $note The document note
     * @return self Returns this instance for method chaining
     */
    public function setNote(?string $note): self
    {
        $this->note->setValue($note);
        return $this;
    }

    /**
     * Adds an inventory item
     *
     * @param InventoryItem $item The inventory item to add
     * @return self Returns this instance for method chaining
     */
    public function addItem(InventoryItem $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Sets all inventory items
     *
     * @param InventoryItem[] $items The inventory items to set
     * @return self Returns this instance for method chaining
     */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Gets all inventory items
     *
     * @return InventoryItem[] The inventory items
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Serializes the inventory document to XML
     *
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('InvDokl');

        $this->documentNumber->serialize($writer);
        $this->inventoryId->serialize($writer);
        $this->description->serialize($writer);
        $this->worker->serialize($writer);
        $this->controller->serialize($writer);
        $this->note->serialize($writer);

        foreach ($this->items as $item) {
            $item->serialize($writer);
        }

        $writer->endElement();
    }
}
