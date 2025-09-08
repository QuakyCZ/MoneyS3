<?php

namespace eProduct\MoneyS3;

use eProduct\MoneyS3\Document\Invoice\Invoice;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Document\Receipt\Receipt;
use XMLWriter;

class MoneyS3
{
    private MoneyS3Data $data;
    
    public function __construct(private readonly string $ico)
    {
        $this->data = new MoneyS3Data();
    }

    public function addInvoice(InvoiceType $type): Invoice {
        $invoice = new Invoice($type);
        $this->data->invoices[$type->value][] = $invoice;
        return $invoice;
    }

    public function addReceipt(): Receipt {
        $receipt = new Receipt();
        $this->data->receipts[] = $receipt;
        return $receipt;
    }

    public function getXml(): string
    {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement('MoneyData');
        $writer->writeAttribute('ICAgendy', $this->ico);
        $writer->writeAttribute('JazykVerze', 'CZ');
        $this->data->serialize($writer);
        $writer->endElement();
        return $writer->outputMemory();
    }
}