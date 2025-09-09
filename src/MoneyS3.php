<?php

namespace eProduct\MoneyS3;

use eProduct\MoneyS3\Document\Invoice\Invoice;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Document\Receipt\Receipt;
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
     * Generates XML representation of all data
     * 
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