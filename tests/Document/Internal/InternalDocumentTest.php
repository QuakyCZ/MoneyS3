<?php

namespace eProduct\MoneyS3\Test\Document\Internal;

use DateTime;
use eProduct\MoneyS3\Document\Internal\InternalDocument;
use PHPUnit\Framework\TestCase;
use XMLWriter;

class InternalDocumentTest extends TestCase
{
    private InternalDocument $document;

    protected function setUp(): void
    {
        $this->document = new InternalDocument();
    }

    public function testSetDocumentNumber(): void
    {
        $result = $this->document->setDocumentNumber('INT001');
        $this->assertSame($this->document, $result);
    }

    public function testSetDescription(): void
    {
        $result = $this->document->setDescription('Internal accounting entry');
        $this->assertSame($this->document, $result);
    }

    public function testSetAccountingDate(): void
    {
        $date = new DateTime('2023-01-01');
        $result = $this->document->setAccountingDate($date);
        $this->assertSame($this->document, $result);
    }

    public function testSetTaxableSupplyDate(): void
    {
        $date = new DateTime('2023-01-01');
        $result = $this->document->setTaxableSupplyDate($date);
        $this->assertSame($this->document, $result);
    }

    public function testSetStorno(): void
    {
        $result = $this->document->setStorno(1);
        $this->assertSame($this->document, $result);
    }

    public function testSetCenter(): void
    {
        $result = $this->document->setCenter('MAIN');
        $this->assertSame($this->document, $result);
    }

    public function testSetProject(): void
    {
        $result = $this->document->setProject('PROJ001');
        $this->assertSame($this->document, $result);
    }

    public function testSetActivity(): void
    {
        $result = $this->document->setActivity('ACT001');
        $this->assertSame($this->document, $result);
    }

    public function testSerializeWithMinimalData(): void
    {
        $this->document->setDocumentNumber('INT001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $this->document->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<IntDokl>', $xml);
        $this->assertStringContainsString('<Doklad>INT001</Doklad>', $xml);
        $this->assertStringContainsString('</IntDokl>', $xml);
    }

    public function testSerializeWithAllFields(): void
    {
        $accountingDate = new DateTime('2023-01-01');
        $taxableSupplyDate = new DateTime('2023-01-01');
        
        $this->document
            ->setDocumentNumber('INT001')
            ->setDescription('Internal Entry')
            ->setAccountingDate($accountingDate)
            ->setTaxableSupplyDate($taxableSupplyDate)
            ->setStorno(0)
            ->setCenter('MAIN')
            ->setProject('PROJ001')
            ->setActivity('ACT001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $this->document->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<IntDokl>', $xml);
        $this->assertStringContainsString('<Doklad>INT001</Doklad>', $xml);
        $this->assertStringContainsString('<Popis>Internal Entry</Popis>', $xml);
        $this->assertStringContainsString('<DatUcPr>2023-01-01</DatUcPr>', $xml);
        $this->assertStringContainsString('<DatPln>2023-01-01</DatPln>', $xml);
        $this->assertStringContainsString('<Storno>0</Storno>', $xml);
        $this->assertStringContainsString('<Stred>MAIN</Stred>', $xml);
        $this->assertStringContainsString('<Zakazka>PROJ001</Zakazka>', $xml);
        $this->assertStringContainsString('<Cinnost>ACT001</Cinnost>', $xml);
        $this->assertStringContainsString('</IntDokl>', $xml);
    }
}
