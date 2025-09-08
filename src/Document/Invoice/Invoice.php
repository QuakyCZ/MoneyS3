<?php

namespace eprehled\MoneyS3\Document\Invoice;

use eprehled\MoneyS3\Document\IDocument;

class Invoice implements IDocument
{
    public function __construct(public readonly InvoiceType $invoiceType)
    {
    }
}