<?php

namespace eProduct\MoneyS3\Test\Document\Invoice;

use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use PHPUnit\Framework\TestCase;

class InvoiceTypeTest extends TestCase
{
    public function testInvoiceTypeEnumValues(): void
    {
        $this->assertEquals('issued', InvoiceType::ISSUED->value);
        $this->assertEquals('received', InvoiceType::RECEIVED->value);
    }

    public function testGetRootElementForIssued(): void
    {
        $this->assertEquals('FaktVyd', InvoiceType::ISSUED->getRootElement());
    }

    public function testGetRootElementForReceived(): void
    {
        $this->assertEquals('FaktPrij', InvoiceType::RECEIVED->getRootElement());
    }

    public function testGetListRootElementForIssued(): void
    {
        $this->assertEquals('SeznamFaktVyd', InvoiceType::ISSUED->getListRootElement());
    }

    public function testGetListRootElementForReceived(): void
    {
        $this->assertEquals('SeznamFaktPrij', InvoiceType::RECEIVED->getListRootElement());
    }

    public function testEnumFromString(): void
    {
        $this->assertEquals(InvoiceType::ISSUED, InvoiceType::from('issued'));
        $this->assertEquals(InvoiceType::RECEIVED, InvoiceType::from('received'));
    }

    public function testAllCasesAreCovered(): void
    {
        $cases = InvoiceType::cases();
        $this->assertCount(2, $cases);
        $this->assertContains(InvoiceType::ISSUED, $cases);
        $this->assertContains(InvoiceType::RECEIVED, $cases);
    }
}
