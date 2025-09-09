<?php

namespace eProduct\MoneyS3\Test;

use eProduct\MoneyS3\MoneyS3Data;
use eProduct\MoneyS3\Document\Invoice\Invoice;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Document\Receipt\Receipt;
use PHPUnit\Framework\TestCase;
use XMLWriter;

class MoneyS3DataTest extends TestCase
{
    private MoneyS3Data $data;
    private XMLWriter $writer;

    protected function setUp(): void
    {
        $this->data = new MoneyS3Data();
        $this->writer = new XMLWriter();
        $this->writer->openMemory();
        $this->writer->startDocument('1.0', 'UTF-8');
    }

    public function testInitialState(): void
    {
        $this->assertIsArray($this->data->invoices); // @phpstan-ignore-line
        $this->assertEmpty($this->data->invoices);
        $this->assertIsArray($this->data->receipts); // @phpstan-ignore-line
        $this->assertEmpty($this->data->receipts);
    }

    public function testSerializeEmpty(): void
    {
        $this->data->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertIsString($xml); // @phpstan-ignore-line
        // Should not contain any invoice or receipt elements
        $this->assertStringNotContainsString('<SeznamFaktVyd>', $xml);
        $this->assertStringNotContainsString('<SeznamFaktPrij>', $xml);
        $this->assertStringNotContainsString('<Prijemka>', $xml);
    }

    public function testSerializeWithIssuedInvoices(): void
    {
        $invoice1 = new Invoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001');
        
        $invoice2 = new Invoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023002');
        
        $this->data->invoices[InvoiceType::ISSUED->value] = [$invoice1, $invoice2];
        
        $this->data->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringContainsString('<SeznamFaktVyd>', $xml);
        $this->assertStringContainsString('<Doklad>2023001</Doklad>', $xml);
        $this->assertStringContainsString('<Doklad>2023002</Doklad>', $xml);
        $this->assertStringContainsString('</SeznamFaktVyd>', $xml);
    }

    public function testSerializeWithReceivedInvoices(): void
    {
        $invoice = new Invoice(InvoiceType::RECEIVED);
        $invoice->setDocumentNumber('IN001');
        
        $this->data->invoices[InvoiceType::RECEIVED->value] = [$invoice];
        
        $this->data->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringContainsString('<SeznamFaktPrij>', $xml);
        $this->assertStringContainsString('<Doklad>IN001</Doklad>', $xml);
        $this->assertStringContainsString('</SeznamFaktPrij>', $xml);
    }

    public function testSerializeWithBothInvoiceTypes(): void
    {
        $issuedInvoice = new Invoice(InvoiceType::ISSUED);
        $issuedInvoice->setDocumentNumber('OUT001');
        
        $receivedInvoice = new Invoice(InvoiceType::RECEIVED);
        $receivedInvoice->setDocumentNumber('IN001');
        
        $this->data->invoices[InvoiceType::ISSUED->value] = [$issuedInvoice];
        $this->data->invoices[InvoiceType::RECEIVED->value] = [$receivedInvoice];
        
        $this->data->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringContainsString('<SeznamFaktVyd>', $xml);
        $this->assertStringContainsString('<SeznamFaktPrij>', $xml);
        $this->assertStringContainsString('<Doklad>OUT001</Doklad>', $xml);
        $this->assertStringContainsString('<Doklad>IN001</Doklad>', $xml);
    }

    public function testSerializeWithReceipts(): void
    {
        $receipt1 = new Receipt();
        $receipt2 = new Receipt();
        
        $this->data->receipts = [$receipt1, $receipt2];
        
        $this->data->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        // Should contain two receipt elements
        $this->assertEquals(2, substr_count($xml, '<Prijemka>'));
        $this->assertEquals(2, substr_count($xml, '</Prijemka>'));
    }

    public function testSerializeWithMixedContent(): void
    {
        $issuedInvoice = new Invoice(InvoiceType::ISSUED);
        $issuedInvoice->setDocumentNumber('OUT001');
        
        $receipt = new Receipt();
        
        $this->data->invoices[InvoiceType::ISSUED->value] = [$issuedInvoice];
        $this->data->receipts = [$receipt];
        
        $this->data->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringContainsString('<SeznamFaktVyd>', $xml);
        $this->assertStringContainsString('<Doklad>OUT001</Doklad>', $xml);
        $this->assertStringContainsString('<Prijemka>', $xml);
    }

    public function testInvoicesArrayStructure(): void
    {
        // Test that invoices are properly organized by type
        $issuedInvoice = new Invoice(InvoiceType::ISSUED);
        $receivedInvoice = new Invoice(InvoiceType::RECEIVED);
        
        $this->data->invoices['issued'] = [$issuedInvoice];
        $this->data->invoices['received'] = [$receivedInvoice];
        
        $this->assertArrayHasKey('issued', $this->data->invoices);
        $this->assertArrayHasKey('received', $this->data->invoices);
        $this->assertCount(1, $this->data->invoices['issued']);
        $this->assertCount(1, $this->data->invoices['received']);
    }

    public function testSerializeGeneratesValidXml(): void
    {
        $invoice = new Invoice(InvoiceType::ISSUED);
        $invoice->setDocumentNumber('2023001');
        $receipt = new Receipt();
        
        $this->data->invoices[InvoiceType::ISSUED->value] = [$invoice];
        $this->data->receipts = [$receipt];
        
        // Wrap in a root element to make it valid XML
        $this->writer->startElement('Root');
        $this->data->serialize($this->writer);
        $this->writer->endElement();
        $xml = $this->writer->outputMemory();
        
        // Test that XML is well-formed
        $dom = new \DOMDocument();
        $result = $dom->loadXML($xml);
        
        $this->assertTrue($result, 'Generated data XML should be well-formed');
    }
}
