<?php

namespace eProduct\MoneyS3;

use eProduct\MoneyS3\Document\Accounting\AccountingDocument;
use eProduct\MoneyS3\Document\Accounting\AccountingDocumentType;
use eProduct\MoneyS3\Document\Internal\InternalDocument;
use eProduct\MoneyS3\Document\Inventory\InventoryDocument;
use eProduct\MoneyS3\Document\Invoice\Invoice;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Document\Order\Order;
use eProduct\MoneyS3\Document\Order\OrderType;
use eProduct\MoneyS3\Document\Receipt\Receipt;
use eProduct\MoneyS3\Document\Warehouse\WarehouseDocument;
use eProduct\MoneyS3\Document\Warehouse\WarehouseType;
use XMLWriter;

class MoneyS3
{
    private MoneyS3Data $data;
    
    /**
     * Constructor for MoneyS3 class
     * 
     * @param string $ico The ICO (company identification number) for the organization
     */
    public function __construct(private readonly string $ico)
    {
        $this->data = new MoneyS3Data();
    }

    /**
     * Adds a new invoice to the data collection
     * 
     * @param InvoiceType $type The type of invoice (issued or received)
     * @return Invoice The created invoice instance for method chaining
     */
    public function addInvoice(InvoiceType $type): Invoice {
        $invoice = new Invoice($type);
        $this->data->invoices[$type->value][] = $invoice;
        return $invoice;
    }

    /**
     * Adds an existing invoice to the data collection
     * 
     * @param Invoice $invoice The invoice to add
     * @return self Returns this instance for method chaining
     */
    public function addInvoiceRaw(Invoice $invoice): self {
        $this->data->invoices[$invoice->invoiceType->value][] = $invoice;
        return $this;
    }

    /**
     * Adds a new receipt to the data collection
     * 
     * @return Receipt The created receipt instance for method chaining
     */
    public function addReceipt(): Receipt {
        $receipt = new Receipt();
        $this->data->receipts[] = $receipt;
        return $receipt;
    }

    /**
     * Adds an existing receipt to the data collection
     * 
     * @param Receipt $receipt The receipt to add
     * @return self Returns this instance for method chaining
     */
    public function addReceiptRaw(Receipt $receipt): self {
        $this->data->receipts[] = $receipt;
        return $this;
    }

    /**
     * Adds a new order to the data collection
     * 
     * @param OrderType $type The type of order
     * @return Order The created order instance for method chaining
     */
    public function addOrder(OrderType $type): Order {
        $order = new Order($type);
        $this->data->orders[$type->value][] = $order;
        return $order;
    }

    /**
     * Adds an existing order to the data collection
     * 
     * @param Order $order The order to add
     * @return self Returns this instance for method chaining
     */
    public function addOrderRaw(Order $order): self {
        $this->data->orders[$order->orderType->value][] = $order;
        return $this;
    }

    /**
     * Adds a new warehouse document to the data collection
     * 
     * @param WarehouseType $type The type of warehouse document
     * @return WarehouseDocument The created warehouse document instance for method chaining
     */
    public function addWarehouseDocument(WarehouseType $type): WarehouseDocument {
        $document = new WarehouseDocument($type);
        $this->data->warehouseDocuments[$type->value][] = $document;
        return $document;
    }

    /**
     * Adds an existing warehouse document to the data collection
     * 
     * @param WarehouseDocument $document The warehouse document to add
     * @return self Returns this instance for method chaining
     */
    public function addWarehouseDocumentRaw(WarehouseDocument $document): self {
        $this->data->warehouseDocuments[$document->warehouseType->value][] = $document;
        return $this;
    }

    /**
     * Adds a new internal document to the data collection
     * 
     * @return InternalDocument The created internal document instance for method chaining
     */
    public function addInternalDocument(): InternalDocument {
        $document = new InternalDocument();
        $this->data->internalDocuments[] = $document;
        return $document;
    }

    /**
     * Adds an existing internal document to the data collection
     * 
     * @param InternalDocument $document The internal document to add
     * @return self Returns this instance for method chaining
     */
    public function addInternalDocumentRaw(InternalDocument $document): self {
        $this->data->internalDocuments[] = $document;
        return $this;
    }

    /**
     * Adds a new accounting document to the data collection
     * 
     * @param AccountingDocumentType $type The type of accounting document (bank or cash)
     * @return AccountingDocument The created accounting document instance for method chaining
     */
    public function addAccountingDocument(AccountingDocumentType $type): AccountingDocument {
        $document = new AccountingDocument($type);
        $this->data->accountingDocuments[$type->value][] = $document;
        return $document;
    }

    /**
     * Adds an existing accounting document to the data collection
     * 
     * @param AccountingDocument $document The accounting document to add
     * @return self Returns this instance for method chaining
     */
    public function addAccountingDocumentRaw(AccountingDocument $document): self {
        $this->data->accountingDocuments[$document->documentType->value][] = $document;
        return $this;
    }

    /**
     * Adds a new inventory document to the data collection
     * 
     * @return InventoryDocument The created inventory document instance for method chaining
     */
    public function addInventoryDocument(): InventoryDocument {
        $document = new InventoryDocument();
        $this->data->inventoryDocuments[] = $document;
        return $document;
    }

    /**
     * Adds an existing inventory document to the data collection
     * 
     * @param InventoryDocument $document The inventory document to add
     * @return self Returns this instance for method chaining
     */
    public function addInventoryDocumentRaw(InventoryDocument $document): self {
        $this->data->inventoryDocuments[] = $document;
        return $this;
    }

    /**
     * Generates XML representation of all data
     * 
     * @param bool $flushMemory Whether to flush memory after generating XML
     * @return string The complete XML document as a string
     */
    public function getXml(bool $flushMemory = true): string {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement('MoneyData');
        $writer->writeAttribute('ICAgendy', $this->ico);
        $writer->writeAttribute('JazykVerze', 'CZ');
        $this->data->serialize($writer);
        $writer->endElement();

        if ($flushMemory) {
            $this->data = new MoneyS3Data();
        }

        return $writer->outputMemory($flushMemory);
    }
}