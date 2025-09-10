<?php

namespace eProduct\MoneyS3\Test\Document\Invoice;

use eProduct\MoneyS3\Document\Invoice\Invoice;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Document\Invoice\Partner;
use eProduct\MoneyS3\Document\Invoice\VatSummary;
use eProduct\MoneyS3\Document\Invoice\Company;
use eProduct\MoneyS3\Document\Invoice\FinalRecipient;
use eProduct\MoneyS3\Document\Invoice\InvoiceItem;
use PHPUnit\Framework\TestCase;
use XMLWriter;

class InvoiceTest extends TestCase
{
    private Invoice $invoice;
    private XMLWriter $writer;

    protected function setUp(): void
    {
        $this->invoice = new Invoice(InvoiceType::ISSUED);
        $this->writer = new XMLWriter();
        $this->writer->openMemory();
        $this->writer->startDocument('1.0', 'UTF-8');
    }

    public function testConstructorSetsInvoiceType(): void
    {
        $issuedInvoice = new Invoice(InvoiceType::ISSUED);
        $receivedInvoice = new Invoice(InvoiceType::RECEIVED);

        $this->assertEquals(InvoiceType::ISSUED, $issuedInvoice->invoiceType);
        $this->assertEquals(InvoiceType::RECEIVED, $receivedInvoice->invoiceType);
    }

    public function testSetDocumentNumber(): void
    {
        $documentNumber = '2023001';
        $result = $this->invoice->setDocumentNumber($documentNumber);

        $this->assertSame($this->invoice, $result); // Test fluent interface
    }

    public function testFluentInterface(): void
    {
        $result = $this->invoice
            ->setDocumentNumber('2023001')
            ->setDescription('Test Invoice')
            ->setTotal(1000.00);

        $this->assertSame($this->invoice, $result);
    }

    public function testSerializeBasicInvoice(): void
    {
        $company = new Company();
        $company->setInvoiceName('My Company');
        $this->invoice
            ->setMyCompany($company)
            ->setDocumentNumber('2023001')
            ->setDescription('Test Invoice')
            ->setTotal(1000.00);

        $this->invoice->serialize($this->writer);
        $xml = $this->writer->outputMemory();

        $this->assertStringContainsString('<FaktVyd>', $xml);
        $this->assertStringContainsString('<Doklad>2023001</Doklad>', $xml);
        $this->assertStringContainsString('<Popis>Test Invoice</Popis>', $xml);
        $this->assertStringContainsString('<Celkem>1000</Celkem>', $xml);
        $this->assertStringContainsString('</FaktVyd>', $xml);
    }

    public function testSerializeReceivedInvoice(): void
    {
        $company = new Company();
        $company->setInvoiceName('My Company');

        $receivedInvoice = new Invoice(InvoiceType::RECEIVED);
        $receivedInvoice->setDocumentNumber('IN001')
            ->setMyCompany($company);

        $receivedInvoice->serialize($this->writer);
        $xml = $this->writer->outputMemory();

        $this->assertStringContainsString('<FaktPrij>', $xml);
        $this->assertStringContainsString('<Doklad>IN001</Doklad>', $xml);
        $this->assertStringContainsString('</FaktPrij>', $xml);
    }

    public function testAllSetterMethods(): void
    {
        // Test all setter methods to ensure they work and return the invoice instance
        $methods = [
            'setAccountingMethod' => 1,
            'setNumberSeries' => 1,
            'setIssued' => new \DateTime('2023-01-01'),
            'setAccountingDate' => new \DateTime('2023-01-01'),
            'setVatPerformed' => '2023-01-01',
            'setDueDate' => new \DateTime('2023-01-31'),
            'setTaxDocumentDate' => new \DateTime('2023-01-01'),
            'setSimplified' => false,
            'setVariableSymbol' => '123456',
            'setAccount' => 'account123',
            'setType' => 'standard',
            'setCreditNote' => false,
            'setVatCalculationMethod' => 'standard',
            'setVatRate1' => 21,
            'setVatRate2' => 15,
            'setToPay' => 1000.00,
            'setSettled' => false,
            'setReceivableRemaining' => '1000.00',
            'setCurrenciesProperty' => 'CZK',
            'setDepositSum' => '0.00',
            'setDepositSumTotal' => '0.00',
            'setDomesticTransport' => '100.00',
            'setForeignTransport' => '0.00',
            'setDiscount' => '0.00',
        ];

        foreach ($methods as $method => $value) {
            $result = $this->invoice->$method($value);
            $this->assertSame($this->invoice, $result, "Method $method should return invoice instance");
        }
    }

    public function testSerializeWithAllFields(): void
    {
        $this->invoice
            ->setDocumentNumber('2023001')
            ->setAccountingMethod(1)
            ->setNumberSeries(1)
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
            )
            ->setDescription('Test Invoice')
            ->setIssued(new \DateTime('2023-01-01'))
            ->setAccountingDate(new \DateTime('2023-01-01'))
            ->setVatPerformed('2023-01-01')
            ->setDueDate(new \DateTime('2023-01-31'))
            ->setVariableSymbol('123456')
            ->setTotal(1000.00);

        $this->invoice->serialize($this->writer);
        $xml = $this->writer->outputMemory();

        //print_r($xml); // Uncomment for debugging

        $expectedElements = [
            '<Doklad>2023001</Doklad>',
            '<ZpusobUctovani>1</ZpusobUctovani>',
            '<CisRada>1</CisRada>',
            '<MojeFirma><FaktNazev>Test Company</FaktNazev></MojeFirma>',
            '<Popis>Test Invoice</Popis>',
            '<Vystaveno>2023-01-01</Vystaveno>',
            '<DatUcPr>2023-01-01</DatUcPr>',
            '<PlnenoDPH>2023-01-01</PlnenoDPH>',
            '<Splatno>2023-01-31</Splatno>',
            '<VarSymbol>123456</VarSymbol>',
            '<Celkem>1000</Celkem>',
        ];

        foreach ($expectedElements as $element) {
            $this->assertStringContainsString($element, $xml);
        }
    }

    public function testSerializeWithItemsList(): void
    {
        // Create mock invoice item
        $mockItem = $this->createMock(InvoiceItem::class);
        $mockItem->expects($this->once())
            ->method('serialize')
            ->with($this->isInstanceOf(XMLWriter::class));
        $company = new Company();
        $company->setInvoiceName('My Company');
        $this->invoice->setMyCompany($company);
        $this->invoice->setItemsList([$mockItem]);
        $this->invoice->setDocumentNumber('2023001');
        $this->invoice->serialize($this->writer);
        $xml = $this->writer->outputMemory();

        $this->assertStringContainsString('<SeznamPolozek>', $xml);
        $this->assertStringContainsString('<Polozka', $xml);
        $this->assertStringContainsString('</SeznamPolozek>', $xml);
    }

    public function testSerializeWithoutItemsList(): void
    {
        $company = new Company();
        $company->setInvoiceName('My Company');
        $this->invoice->setMyCompany($company);
        $this->invoice->setDocumentNumber('2023001');
        $this->invoice->serialize($this->writer);
        $xml = $this->writer->outputMemory();

        $this->assertStringNotContainsString('<SeznamPolozek>', $xml);
    }

    public function testSerializeWithComplexObjects(): void
    {
        // Create mock objects for complex properties
        $mockVatSummary = $this->createMock(VatSummary::class);
        $mockVatSummary->expects($this->once())
            ->method('serialize')
            ->with($this->isInstanceOf(XMLWriter::class));

        $mockPartner = $this->createMock(Partner::class);
        $mockPartner->expects($this->once())
            ->method('serialize')
            ->with($this->isInstanceOf(XMLWriter::class));

        $mockCompany = $this->createMock(Company::class);
        $mockCompany->expects($this->once())
            ->method('serialize')
            ->with($this->isInstanceOf(XMLWriter::class));

        $mockFinalRecipient = $this->createMock(FinalRecipient::class);
        $mockFinalRecipient->expects($this->once())
            ->method('serialize')
            ->with($this->isInstanceOf(XMLWriter::class));

        $this->invoice
            ->setVatSummary($mockVatSummary)
            ->setPartner($mockPartner)
            ->setMyCompany($mockCompany)
            ->setFinalRecipient($mockFinalRecipient)
            ->setDocumentNumber('2023001');

        $this->invoice->serialize($this->writer);

        // The mocks ensure that serialize is called on each object
    }

    public function testXmlStructureIsValid(): void
    {
        $company = new Company();
        $company->setInvoiceName('My Company');
        $this->invoice->setMyCompany($company);
        $this->invoice->setDocumentNumber('2023001');
        $this->invoice->serialize($this->writer);
        $xml = $this->writer->outputMemory();

        // Test that XML is well-formed
        $dom = new \DOMDocument();
        $result = $dom->loadXML($xml);

        $this->assertTrue($result, 'Generated invoice XML should be well-formed');
    }
}
