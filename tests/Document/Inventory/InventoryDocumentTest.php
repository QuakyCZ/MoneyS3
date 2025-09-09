<?php

namespace eProduct\MoneyS3\Test\Document\Inventory;

use eProduct\MoneyS3\Document\Inventory\InventoryDocument;
use PHPUnit\Framework\TestCase;
use XMLWriter;

class InventoryDocumentTest extends TestCase
{
    private InventoryDocument $document;

    protected function setUp(): void
    {
        $this->document = new InventoryDocument();
    }

    public function testSetDocumentNumber(): void
    {
        $result = $this->document->setDocumentNumber(123);
        $this->assertSame($this->document, $result);
    }

    public function testSetInventoryId(): void
    {
        $result = $this->document->setInventoryId(456);
        $this->assertSame($this->document, $result);
    }

    public function testSetDescription(): void
    {
        $result = $this->document->setDescription('Inventory check');
        $this->assertSame($this->document, $result);
    }

    public function testSetWorker(): void
    {
        $result = $this->document->setWorker('John Doe');
        $this->assertSame($this->document, $result);
    }

    public function testSetController(): void
    {
        $result = $this->document->setController('Jane Smith');
        $this->assertSame($this->document, $result);
    }

    public function testSetNote(): void
    {
        $result = $this->document->setNote('Annual inventory');
        $this->assertSame($this->document, $result);
    }

    public function testSerializeWithMinimalData(): void
    {
        $this->document
            ->setDocumentNumber(123)
            ->setInventoryId(456);
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $this->document->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<InvDokl>', $xml);
        $this->assertStringContainsString('<CisloD>123</CisloD>', $xml);
        $this->assertStringContainsString('<InvID>456</InvID>', $xml);
        $this->assertStringContainsString('</InvDokl>', $xml);
    }

    public function testSerializeWithAllFields(): void
    {
        $this->document
            ->setDocumentNumber(123)
            ->setInventoryId(456)
            ->setDescription('Annual Inventory')
            ->setWorker('John Doe')
            ->setController('Jane Smith')
            ->setNote('Complete inventory check');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $this->document->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<InvDokl>', $xml);
        $this->assertStringContainsString('<CisloD>123</CisloD>', $xml);
        $this->assertStringContainsString('<InvID>456</InvID>', $xml);
        $this->assertStringContainsString('<Popis>Annual Inventory</Popis>', $xml);
        $this->assertStringContainsString('<Prac>John Doe</Prac>', $xml);
        $this->assertStringContainsString('<Kontr>Jane Smith</Kontr>', $xml);
        $this->assertStringContainsString('<Poznamka>Complete inventory check</Poznamka>', $xml);
        $this->assertStringContainsString('</InvDokl>', $xml);
    }
}
