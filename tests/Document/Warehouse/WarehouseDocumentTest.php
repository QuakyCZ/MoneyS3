<?php

namespace eProduct\MoneyS3\Test\Document\Warehouse;

use DateTime;
use eProduct\MoneyS3\Document\Warehouse\WarehouseDocument;
use eProduct\MoneyS3\Document\Warehouse\WarehouseType;
use PHPUnit\Framework\TestCase;
use XMLWriter;

class WarehouseDocumentTest extends TestCase
{
    private WarehouseDocument $document;

    protected function setUp(): void
    {
        $this->document = new WarehouseDocument(WarehouseType::RECEIPT);
    }

    public function testConstructorSetsWarehouseType(): void
    {
        $this->assertEquals(WarehouseType::RECEIPT, $this->document->warehouseType);
    }

    public function testSetDocumentNumber(): void
    {
        $result = $this->document->setDocumentNumber('PRI001');
        $this->assertSame($this->document, $result);
    }

    public function testSetOrderNumber(): void
    {
        $result = $this->document->setOrderNumber('ORD123');
        $this->assertSame($this->document, $result);
    }

    public function testSetDate(): void
    {
        $date = new DateTime('2023-01-01');
        $result = $this->document->setDate($date);
        $this->assertSame($this->document, $result);
    }

    public function testSetTotal(): void
    {
        $result = $this->document->setTotal(1500.00);
        $this->assertSame($this->document, $result);
    }

    public function testSetPartner(): void
    {
        $result = $this->document->setPartner('Test Partner');
        $this->assertSame($this->document, $result);
    }

    public function testSetAccountingMethod(): void
    {
        $result = $this->document->setAccountingMethod(1);
        $this->assertSame($this->document, $result);
    }

    public function testSerializeWithMinimalData(): void
    {
        $this->document->setDocumentNumber('PRI001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $this->document->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<Prijemka>', $xml);
        $this->assertStringContainsString('<CisloDokla>PRI001</CisloDokla>', $xml);
        $this->assertStringContainsString('</Prijemka>', $xml);
    }

    public function testSerializeWithAllFields(): void
    {
        $date = new DateTime('2023-01-01');
        
        $this->document
            ->setDocumentNumber('PRI001')
            ->setAccountingMethod(1)
            ->setOrderNumber('ORD123')
            ->setDate($date)
            ->setTotal(1500.00)
            ->setPartner('Test Partner');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $this->document->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<Prijemka>', $xml);
        $this->assertStringContainsString('<CisloDokla>PRI001</CisloDokla>', $xml);
        $this->assertStringContainsString('<ZpusobUctovani>1</ZpusobUctovani>', $xml);
        $this->assertStringContainsString('<CObjednavk>ORD123</CObjednavk>', $xml);
        $this->assertStringContainsString('<Datum>2023-01-01</Datum>', $xml);
        $this->assertStringContainsString('<Celkem>1500</Celkem>', $xml);
        $this->assertStringContainsString('<DodOdb>Test Partner</DodOdb>', $xml);
        $this->assertStringContainsString('</Prijemka>', $xml);
    }

    public function testSerializeIssueDocument(): void
    {
        $issueDocument = new WarehouseDocument(WarehouseType::ISSUE);
        $issueDocument->setDocumentNumber('VYD001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $issueDocument->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<Vydejka>', $xml);
        $this->assertStringContainsString('<CisloDokla>VYD001</CisloDokla>', $xml);
        $this->assertStringContainsString('</Vydejka>', $xml);
    }

    public function testSerializeDeliveryNote(): void
    {
        $deliveryNote = new WarehouseDocument(WarehouseType::DELIVERY_NOTE_RECEIVED);
        $deliveryNote->setDocumentNumber('DL001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $deliveryNote->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<DLPrij>', $xml);
        $this->assertStringContainsString('<CisloDokla>DL001</CisloDokla>', $xml);
        $this->assertStringContainsString('</DLPrij>', $xml);
    }

    public function testSerializeSalesReceipt(): void
    {
        $salesReceipt = new WarehouseDocument(WarehouseType::SALES_RECEIPT);
        $salesReceipt->setDocumentNumber('PROD001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $salesReceipt->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<Prodejka>', $xml);
        $this->assertStringContainsString('<CisloDokla>PROD001</CisloDokla>', $xml);
        $this->assertStringContainsString('</Prodejka>', $xml);
    }

    public function testSerializeTransfer(): void
    {
        $transfer = new WarehouseDocument(WarehouseType::TRANSFER);
        $transfer->setDocumentNumber('PREV001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $transfer->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<Prevodka>', $xml);
        $this->assertStringContainsString('<CisloDokla>PREV001</CisloDokla>', $xml);
        $this->assertStringContainsString('</Prevodka>', $xml);
    }

    public function testSerializeProduction(): void
    {
        $production = new WarehouseDocument(WarehouseType::PRODUCTION);
        $production->setDocumentNumber('VYR001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $production->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<Vyrobka>', $xml);
        $this->assertStringContainsString('<CisloDokla>VYR001</CisloDokla>', $xml);
        $this->assertStringContainsString('</Vyrobka>', $xml);
    }
}
