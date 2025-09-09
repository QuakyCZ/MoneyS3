<?php

namespace eProduct\MoneyS3\Test\Document\Accounting;

use DateTime;
use eProduct\MoneyS3\Document\Accounting\AccountingDocument;
use eProduct\MoneyS3\Document\Accounting\AccountingDocumentType;
use PHPUnit\Framework\TestCase;
use XMLWriter;

class AccountingDocumentTest extends TestCase
{
    private AccountingDocument $document;

    protected function setUp(): void
    {
        $this->document = new AccountingDocument(AccountingDocumentType::BANK_DOCUMENT);
    }

    public function testConstructorSetsDocumentType(): void
    {
        $this->assertEquals(AccountingDocumentType::BANK_DOCUMENT, $this->document->documentType);
    }

    public function testSetDocumentNumber(): void
    {
        $result = $this->document->setDocumentNumber('BAN001');
        $this->assertSame($this->document, $result);
    }

    public function testSetDescription(): void
    {
        $result = $this->document->setDescription('Bank transfer');
        $this->assertSame($this->document, $result);
    }

    public function testSetAccountingDate(): void
    {
        $date = new DateTime('2023-01-01');
        $result = $this->document->setAccountingDate($date);
        $this->assertSame($this->document, $result);
    }

    public function testSetIssueDate(): void
    {
        $date = new DateTime('2023-01-01');
        $result = $this->document->setIssueDate($date);
        $this->assertSame($this->document, $result);
    }

    public function testSetTotal(): void
    {
        $result = $this->document->setTotal(2500.00);
        $this->assertSame($this->document, $result);
    }

    public function testSetVariableSymbol(): void
    {
        $result = $this->document->setVariableSymbol('VS123456');
        $this->assertSame($this->document, $result);
    }

    public function testSetCounterpartyAccount(): void
    {
        $result = $this->document->setCounterpartyAccount('123456789/0100');
        $this->assertSame($this->document, $result);
    }

    public function testSerializeWithMinimalData(): void
    {
        $this->document->setDocumentNumber('BAN001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $this->document->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<BanDokl>', $xml);
        $this->assertStringContainsString('<Doklad>BAN001</Doklad>', $xml);
        $this->assertStringContainsString('</BanDokl>', $xml);
    }

    public function testSerializeWithAllFields(): void
    {
        $accountingDate = new DateTime('2023-01-01');
        $issueDate = new DateTime('2023-01-01');
        $paymentDate = new DateTime('2023-01-01');
        
        $this->document
            ->setDocumentNumber('BAN001')
            ->setDescription('Bank Transfer')
            ->setAccountingDate($accountingDate)
            ->setIssueDate($issueDate)
            ->setPaymentDate($paymentDate)
            ->setVariableSymbol('VS123456')
            ->setCounterpartyAccount('123456789/0100')
            ->setTotal(2500.00);
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $this->document->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<BanDokl>', $xml);
        $this->assertStringContainsString('<Doklad>BAN001</Doklad>', $xml);
        $this->assertStringContainsString('<Popis>Bank Transfer</Popis>', $xml);
        $this->assertStringContainsString('<DatUcPr>2023-01-01</DatUcPr>', $xml);
        $this->assertStringContainsString('<DatVyst>2023-01-01</DatVyst>', $xml);
        $this->assertStringContainsString('<DatPlat>2023-01-01</DatPlat>', $xml);
        $this->assertStringContainsString('<VarSym>VS123456</VarSym>', $xml);
        $this->assertStringContainsString('<AdUcet>123456789/0100</AdUcet>', $xml);
        $this->assertStringContainsString('<Celkem>2500</Celkem>', $xml);
        $this->assertStringContainsString('</BanDokl>', $xml);
    }

    public function testSerializeCashDocument(): void
    {
        $document = new AccountingDocument(AccountingDocumentType::CASH_DOCUMENT);
        $document->setDocumentNumber('POK001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $document->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<PokDokl>', $xml);
        $this->assertStringContainsString('<Doklad>POK001</Doklad>', $xml);
        $this->assertStringContainsString('</PokDokl>', $xml);
    }

    public function testSetIsExpense(): void
    {
        $result = $this->document->setIsExpense(true);
        $this->assertSame($this->document, $result);
    }

    public function testSetStatementNumber(): void
    {
        $result = $this->document->setStatementNumber(123);
        $this->assertSame($this->document, $result);
    }

    public function testSetMossStateCode(): void
    {
        $result = $this->document->setMossStateCode('CZ');
        $this->assertSame($this->document, $result);
    }
}
