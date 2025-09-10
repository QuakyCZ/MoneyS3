<?php

namespace eProduct\MoneyS3\Test\Integration;

use eProduct\MoneyS3\Agenda\EAgenda;
use eProduct\MoneyS3\Document\Invoice\Invoice;
use eProduct\MoneyS3\MoneyS3;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use PHPUnit\Framework\TestCase;
use eProduct\MoneyS3\Document\Invoice\Company;


class MoneyS3IntegrationTest extends TestCase
{
    private MoneyS3 $moneyS3;
    private string $testIco;

    protected function setUp(): void
    {
        $this->testIco = '12345678';
        $this->moneyS3 = new MoneyS3($this->testIco);
    }

    public function testCompleteInvoiceWorkflow(): void
    {
        $agenda = $this->moneyS3->getInvoiceAgenda();
        // Create an issued invoice
        $invoice = $agenda->addInvoice(InvoiceType::ISSUED);
        $invoice
            ->setDocumentNumber('2023001')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
            )
            ->setDescription('Test Product')
            ->setIssued(new \DateTime('2023-01-01'))
            ->setDueDate(new \DateTime('2023-01-31'))
            ->setVariableSymbol('123456789')
            ->setTotal(1210.25)
            ->setToPay(1210.25)
            ->setVatRate1(21);

        // Generate XML
        $xmls = $this->moneyS3->getXmls();

        $this->assertCount(1, $xmls);
        $this->assertArrayHasKey(EAgenda::INVOICES_ISSUED_AND_RECEIVED->value, $xmls);

        $xml = $xmls[EAgenda::INVOICES_ISSUED_AND_RECEIVED->value];

        // Verify XML structure
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $xml);
        $this->assertStringContainsString('<MoneyData ICAgendy="12345678" JazykVerze="CZ">', $xml);
        $this->assertStringContainsString('<SeznamFaktVyd>', $xml);
        $this->assertStringContainsString('<FaktVyd>', $xml);
        $this->assertStringContainsString('<Doklad>2023001</Doklad>', $xml);
        $this->assertStringContainsString('<MojeFirma><FaktNazev>Test Company</FaktNazev></MojeFirma>', $xml);
        $this->assertStringContainsString('<Popis>Test Product</Popis>', $xml);
        $this->assertStringContainsString('<Vystaveno>2023-01-01</Vystaveno>', $xml);
        $this->assertStringContainsString('<Splatno>2023-01-31</Splatno>', $xml);
        $this->assertStringContainsString('<VarSymbol>123456789</VarSymbol>', $xml);
        $this->assertStringContainsString('<Celkem>1210.25</Celkem>', $xml);
        $this->assertStringContainsString('<Proplatit>1210.25</Proplatit>', $xml);
        $this->assertStringContainsString('<SazbaDPH1>21</SazbaDPH1>', $xml);
        $this->assertStringContainsString('</FaktVyd>', $xml);
        $this->assertStringContainsString('</SeznamFaktVyd>', $xml);
        $this->assertStringContainsString('</MoneyData>', $xml);
    }

    public function testMultipleInvoices(): void
    {
        $agenda = $this->moneyS3->getInvoiceAgenda();
        // Add multiple invoices
        $issuedInvoice = $agenda->addInvoice(InvoiceType::ISSUED);
        $issuedInvoice->setDocumentNumber('OUT001')
            ->setDescription('Issued Invoice')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        $receivedInvoice = $agenda->addInvoice(InvoiceType::RECEIVED);
        $receivedInvoice->setDocumentNumber('IN001')
            ->setDescription('Received Invoice')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        // Generate XML
        $xmls = $this->moneyS3->getXmls();

        $this->assertCount(1, $xmls);
        $this->assertArrayHasKey(EAgenda::INVOICES_ISSUED_AND_RECEIVED->value, $xmls);

        $xml = $xmls[EAgenda::INVOICES_ISSUED_AND_RECEIVED->value];

        // Verify all elements are present
        $this->assertStringContainsString('<SeznamFaktVyd>', $xml);
        $this->assertStringContainsString('<SeznamFaktPrij>', $xml);
        $this->assertStringContainsString('<Doklad>OUT001</Doklad>', $xml);
        $this->assertStringContainsString('<Doklad>IN001</Doklad>', $xml);
        $this->assertStringContainsString('<Popis>Issued Invoice</Popis>', $xml);
        $this->assertStringContainsString('<Popis>Received Invoice</Popis>', $xml);

        // Should have two receipt elements
        $this->assertEquals(2, substr_count($xml, '<Prijemka>'));
        $this->assertEquals(2, substr_count($xml, '</Prijemka>'));
    }

    public function testXmlValidation(): void
    {

        $agenda = $this->moneyS3->getInvoiceAgenda();
        // Create a complex document structure
        $invoice1 = $agenda->addInvoice(InvoiceType::ISSUED);
        $invoice1
            ->setDocumentNumber('2023001')
            ->setDescription('Complex Invoice')
            ->setIssued(new \DateTime('2023-01-01'))
            ->setDueDate(new \DateTime('2023-01-31'))
            ->setTotal(1000.00)
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        $invoice2 = $agenda->addInvoice(InvoiceType::RECEIVED);
        $invoice2->setDocumentNumber('IN001')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        // Generate XML
        $xmls = $this->moneyS3->getXmls();

        $this->assertCount(1, $xmls);
        $this->assertArrayHasKey(EAgenda::INVOICES_ISSUED_AND_RECEIVED->value, $xmls);

        $xml = $xmls[EAgenda::INVOICES_ISSUED_AND_RECEIVED->value];

        // Validate XML structure
        $dom = new \DOMDocument();
        $dom->validateOnParse = true;
        $result = $dom->loadXML($xml);

        $this->assertTrue($result, 'Generated XML should be well-formed and valid');

        // Verify root element
        $this->assertNotNull($dom->documentElement, 'Document should have a root element');
        $this->assertEquals('MoneyData', $dom->documentElement->nodeName);
        $this->assertEquals($this->testIco, $dom->documentElement->getAttribute('ICAgendy'));
        $this->assertEquals('CZ', $dom->documentElement->getAttribute('JazykVerze'));
    }

    public function testEmptyDocument(): void
    {
        // Generate XML without adding any invoices or receipts
        $xmls = $this->moneyS3->getXmls();

        $this->assertEmpty($xmls, 'No XML should be generated for empty agendas');
    }

    public function testFluentInterfaceChaining(): void
    {

        // Test that we can chain method calls throughout the creation process
        $invoice = $this->moneyS3->getInvoiceAgenda()
            ->addInvoice(InvoiceType::ISSUED)
            ->setDocumentNumber('CHAIN001')
            ->setDescription('Fluent Interface Test')
            ->setIssued(new \DateTime('2023-01-01'))
            ->setDueDate(new \DateTime('2023-01-31'))
            ->setTotal(500.00)
            ->setVatRate1(21)
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        $this->assertInstanceOf(Invoice::class, $invoice);

        $xml = $this->moneyS3->getXmls();

        $this->assertCount(1, $xml);
        $this->assertArrayHasKey(EAgenda::INVOICES_ISSUED_AND_RECEIVED->value, $xml);
        $xml = $xml[EAgenda::INVOICES_ISSUED_AND_RECEIVED->value];

        $this->assertStringContainsString('<Doklad>CHAIN001</Doklad>', $xml);
        $this->assertStringContainsString('<Popis>Fluent Interface Test</Popis>', $xml);
    }

    public function testLargeVolumeData(): void
    {
        // Test with multiple invoices to ensure performance and memory handling
        for ($i = 1; $i <= 10; $i++) {
            $this->moneyS3->getInvoiceAgenda()
                ->addInvoice(InvoiceType::ISSUED)
                ->setDocumentNumber(sprintf("OUT%03d", $i))
                ->setDescription("Test Invoice {$i}")
                ->setTotal((float)($i * 100))
                ->setMyCompany(
                    (new Company())
                        ->setInvoiceName('Test Company')
                        ->setIco('12345678')
                );

            $this->moneyS3->getInvoiceAgenda()
                ->addInvoice(InvoiceType::RECEIVED)
                ->setDocumentNumber(sprintf("IN%03d", $i))
                ->setDescription("Received Invoice {$i}")
                ->setMyCompany(
                    (new Company())
                        ->setInvoiceName('Test Company')
                        ->setIco('12345678')
                );
        }

        $xmls = $this->moneyS3->getXmls();

        $this->assertCount(1, $xmls);
        $this->assertArrayHasKey(EAgenda::INVOICES_ISSUED_AND_RECEIVED->value, $xmls);

        $xml = $xmls[EAgenda::INVOICES_ISSUED_AND_RECEIVED->value];

        // Verify all elements are present
        $this->assertEquals(10, substr_count($xml, '<Doklad>OUT'));
        $this->assertEquals(10, substr_count($xml, '<Doklad>IN'));
        $this->assertEquals(10, substr_count($xml, '<Prijemka>'));

        // Ensure XML is still valid
        $dom = new \DOMDocument();
        $result = $dom->loadXML($xml);
        $this->assertTrue($result, 'Large volume XML should still be well-formed');
    }
}
