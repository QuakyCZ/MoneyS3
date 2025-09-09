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

/**
 * @internal
 */
class MoneyS3Data implements ISerializable
{
    /** @var array<string,Invoice[]> */
    public array $invoices = [];

    /** @var Receipt[] */
    public array $receipts = [];

    /** @var array<string,Order[]> */
    public array $orders = [];

    /** @var array<string,WarehouseDocument[]> */
    public array $warehouseDocuments = [];

    /** @var InternalDocument[] */
    public array $internalDocuments = [];

    /** @var array<string,AccountingDocument[]> */
    public array $accountingDocuments = [];

    /** @var InventoryDocument[] */
    public array $inventoryDocuments = [];

    /**
     * Serializes all documents to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        // Invoices
        foreach ($this->invoices as $invoiceType => $invoices) {
            $type = InvoiceType::from($invoiceType);
            $writer->startElement($type->getListRootElement());
            foreach ($invoices as $invoice) {
                $invoice->serialize($writer);
            }
            $writer->endElement();
        }

        // Receipts  
        if (!empty($this->receipts)) {
            $writer->startElement('SeznamPrijem');
            foreach ($this->receipts as $receipt) {
                $receipt->serialize($writer);
            }
            $writer->endElement();
        }

        // Orders
        foreach ($this->orders as $orderType => $orders) {
            $type = OrderType::from($orderType);
            $listElement = match ($type) {
                OrderType::RECEIVED, OrderType::OFFER_RECEIVED, OrderType::INQUIRY_RECEIVED => 'SeznamObjPrij',
                OrderType::ISSUED, OrderType::OFFER_ISSUED, OrderType::INQUIRY_ISSUED => 'SeznamObjVyd',
            };
            $writer->startElement($listElement);
            foreach ($orders as $order) {
                $order->serialize($writer);
            }
            $writer->endElement();
        }

        // Warehouse documents
        foreach ($this->warehouseDocuments as $warehouseType => $documents) {
            $type = WarehouseType::from($warehouseType);
            $writer->startElement($type->getListRootElement());
            foreach ($documents as $document) {
                $document->serialize($writer);
            }
            $writer->endElement();
        }

        // Internal documents
        if (!empty($this->internalDocuments)) {
            $writer->startElement('SeznamIntDokl');
            foreach ($this->internalDocuments as $document) {
                $document->serialize($writer);
            }
            $writer->endElement();
        }

        // Accounting documents
        foreach ($this->accountingDocuments as $accountingType => $documents) {
            $type = AccountingDocumentType::from($accountingType);
            $listElement = match ($type) {
                AccountingDocumentType::BANK_DOCUMENT => 'SeznamBanDokl',
                AccountingDocumentType::CASH_DOCUMENT => 'SeznamPokDokl',
            };
            $writer->startElement($listElement);
            foreach ($documents as $document) {
                $document->serialize($writer);
            }
            $writer->endElement();
        }

        // Inventory documents
        if (!empty($this->inventoryDocuments)) {
            $writer->startElement('SeznamInvDokl');
            foreach ($this->inventoryDocuments as $document) {
                $document->serialize($writer);
            }
            $writer->endElement();
        }
    }
}