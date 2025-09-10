<?php

declare (strict_types=1);

namespace eProduct\MoneyS3\Agenda;

use eProduct\MoneyS3\Document\Invoice\Invoice;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use XMLWriter;

class InvoiceAgenda implements IAgenda
{
    /** @var Invoice[] */
    private array $issuedInvoices = [];

    /** @var Invoice[] */
    private array $receivedInvoices = [];

    public function getType(): EAgenda
    {
        return EAgenda::INVOICES_ISSUED_AND_RECEIVED;
    }

    public function isEmpty(): bool
    {
        return empty($this->issuedInvoices) && empty($this->receivedInvoices);
    }

    public function flush(): void
    {
        $this->issuedInvoices = [];
        $this->receivedInvoices = [];
    }


    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement(InvoiceType::ISSUED->getListRootElement());
        foreach ($this->issuedInvoices as $invoice) {
            $invoice->serialize($writer);
        }
        $writer->endElement();

        $writer->startElement(InvoiceType::RECEIVED->getListRootElement());
        foreach ($this->receivedInvoices as $invoice) {
            $invoice->serialize($writer);
        }
        $writer->endElement();
    }

    public function addInvoice(InvoiceType $type): Invoice
    {
        $invoice = new Invoice($type);
        if ($type === InvoiceType::ISSUED) {
            $this->issuedInvoices[] = $invoice;
        } else {
            $this->receivedInvoices[] = $invoice;
        }
        return $invoice;
    }

    public function addInvoiceRaw(Invoice $invoice): self
    {
        if ($invoice->invoiceType === InvoiceType::ISSUED) {
            $this->issuedInvoices[] = $invoice;
        } else {
            $this->receivedInvoices[] = $invoice;
        }
        return $this;
    }
}
