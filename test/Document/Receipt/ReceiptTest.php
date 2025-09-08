<?php

namespace eProduct\MoneyS3\Test\Document\Receipt;

use eProduct\MoneyS3\Document\Receipt\Receipt;
use PHPUnit\Framework\TestCase;
use XMLWriter;

class ReceiptTest extends TestCase
{
    private Receipt $receipt;
    private XMLWriter $writer;

    protected function setUp(): void
    {
        $this->receipt = new Receipt();
        $this->writer = new XMLWriter();
        $this->writer->openMemory();
        $this->writer->startDocument('1.0', 'UTF-8');
    }

    public function testConstructor(): void
    {
        $this->assertInstanceOf(Receipt::class, $this->receipt);
    }

    public function testSerialize(): void
    {
        $this->receipt->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringContainsString('<Prijemka>', $xml);
        $this->assertStringContainsString('</Prijemka>', $xml);
    }

    public function testSerializeGeneratesValidXml(): void
    {
        $this->receipt->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        // Test that XML is well-formed
        $dom = new \DOMDocument();
        $result = $dom->loadXML($xml);
        
        $this->assertTrue($result, 'Generated receipt XML should be well-formed');
    }
}
