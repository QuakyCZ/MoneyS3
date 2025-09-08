<?php

namespace eprehled\MoneyS3;

use eprehled\MoneyS3\Document\Invoice\Invoice;
use eprehled\MoneyS3\Document\Invoice\InvoiceType;
use eprehled\MoneyS3\Document\Receipt\Receipt;

class MoneyS3
{
    private MoneyS3Data $data;
    public function __construct(private readonly string $ico)
    {
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
}