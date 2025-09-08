<?php

namespace eProduct\MoneyS3;

use eProduct\MoneyS3\Document\Invoice\Invoice;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Document\Receipt\Receipt;
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

    public function serialize(XMLWriter $writer): void
    {
        foreach ($this->invoices as $invoiceType => $invoices) {
            $type = InvoiceType::from($invoiceType);
            $writer->startElement($type->getListRootElement());
            foreach ($invoices as $invoice) {
                $invoice->serialize($writer);
            }
            $writer->endElement();
        }

        foreach ($this->receipts as $receipt) {
            $receipt->serialize($writer);
        }
    }
}