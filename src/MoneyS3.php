<?php

namespace eProduct\MoneyS3;

use eProduct\MoneyS3\Agenda\AgendaFactory;
use eProduct\MoneyS3\Agenda\EAgenda;
use eProduct\MoneyS3\Agenda\IAgenda;
use eProduct\MoneyS3\Agenda\InvoiceAgenda;
use eProduct\MoneyS3\Agenda\ObligationAgenda;
use eProduct\MoneyS3\Agenda\ReceiptAgenda;
use eProduct\MoneyS3\Document\Invoice\Invoice;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Document\Obligation\Obligation;
use eProduct\MoneyS3\Document\Receipt\Receipt;
use eProduct\MoneyS3\Document\Receipt\ReceiptType;
use XMLWriter;

class MoneyS3
{
    private readonly AgendaFactory $agendaFactory;

    /**
     * Constructor for MoneyS3 class
     *
     * @param string $ico The ICO (company identification number) for the organization
     */
    public function __construct(private readonly string $ico)
    {
        $this->agendaFactory = new AgendaFactory();
    }

    public function getInvoiceAgenda(): InvoiceAgenda
    {
        $agenda = $this->agendaFactory->getInstance(InvoiceAgenda::class);
        return $agenda;
    }

    public function getReceiptAgenda(): ReceiptAgenda
    {
        $agenda = $this->agendaFactory->getInstance(ReceiptAgenda::class);
        return $agenda;
    }

    public function getObligationAgenda(): ObligationAgenda
    {
        $agenda = $this->agendaFactory->getInstance(ObligationAgenda::class);
        return $agenda;
    }

    /**
     * Add a new invoice to the invoice agenda
     *
     * @param InvoiceType $invoiceType Type of invoice (issued or received)
     * @return Invoice
     */
    public function addInvoice(InvoiceType $invoiceType): Invoice
    {
        return $this->getInvoiceAgenda()->addInvoice($invoiceType);
    }

    /**
     * Add a new receipt to the receipt agenda
     *
     * @param ReceiptType $receiptType Type of receipt (expense or income)
     * @return Receipt
     */
    public function addReceipt(ReceiptType $receiptType): Receipt
    {
        return $this->getReceiptAgenda()->addReceipt($receiptType);
    }

    /**
     * Add a new obligation to the obligation agenda
     *
     * @return Obligation
     */
    public function addObligation(): Obligation
    {
        return $this->getObligationAgenda()->addObligation();
    }

    /**
     * Generates XML representation of all data
     *
     * @param bool $flushMemory Whether to flush memory after generating XML
     * @return array<string, string> Generated XML strings for each agenda, keyed by agenda {@see EAgenda}
     */
    public function getXmls(bool $flushMemory = true): array
    {
        $xmls = [];
        foreach ($this->agendaFactory->instances as $agenda) {
            if ($agenda->isEmpty()) {
                continue; // Skip empty agendas
            }
            $writer = new XMLWriter();
            $writer->openMemory();
            $this->serializeDocument($writer, $agenda, $flushMemory);
            $xmls[$agenda->getType()->value] = $writer->outputMemory($flushMemory);
        }

        return $xmls;
    }

    private function serializeDocument(XMLWriter $writer, IAgenda $agenda, bool $flushMemory): void
    {
        $writer->startDocument('1.0', 'UTF-8');
        $this->serializeMoneyData($writer, $agenda, $flushMemory);
        $writer->endDocument();
    }

    private function serializeMoneyData(XMLWriter $writer, IAgenda $agenda, bool $flushMemory): void
    {
        $writer->startElement('MoneyData');
        $writer->writeAttribute('ICAgendy', $this->ico);
        $writer->writeAttribute('JazykVerze', 'CZ');
        $agenda->serialize($writer);
        if ($flushMemory) {
            $agenda->flush();
        }
        $writer->endElement();
    }
}
