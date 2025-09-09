<?php

namespace eProduct\MoneyS3\Test;

use DateTime;
use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Document\Invoice\Company;
use eProduct\MoneyS3\Document\Invoice\Partner;
use eProduct\MoneyS3\Document\Invoice\VatSummary;
use eProduct\MoneyS3\MoneyS3;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Document\Invoice\Invoice;
use eProduct\MoneyS3\Document\Receipt\Receipt;
use PHPUnit\Framework\TestCase;

class MoneyS3Test extends TestCase
{
    private MoneyS3 $moneyS3;
    private string $testIco;

    protected function setUp(): void
    {
        $this->testIco = '12345678';
        $this->moneyS3 = new MoneyS3($this->testIco);
    }

    public function testConstructorSetsIco(): void
    {
        $this->assertInstanceOf(MoneyS3::class, $this->moneyS3);
    }

    public function testAddInvoiceReturnsInvoiceInstance(): void
    {
        $invoice = $this->moneyS3->addInvoice(InvoiceType::ISSUED);
        
        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertEquals(InvoiceType::ISSUED, $invoice->invoiceType);
    }

    public function testAddReceiptReturnsReceiptInstance(): void
    {
        $receipt = $this->moneyS3->addReceipt();
        
        $this->assertInstanceOf(Receipt::class, $receipt);
    }

    public function testGetXmlReturnsValidXmlString(): void
    {

        $xml = $this->moneyS3->getXml();
        
        $this->assertIsString($xml); // @phpstan-ignore-line
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $xml);
        $this->assertStringContainsString('MoneyData', $xml);
        $this->assertStringContainsString('ICAgendy="' . $this->testIco . '"', $xml);
        $this->assertStringContainsString('JazykVerze="CZ"', $xml);
    }

    public function testGetXmlWithInvoices(): void
    {
        $invoice = $this->moneyS3->addInvoice(InvoiceType::ISSUED);
        $invoice->setDocumentNumber('2023001')
               ->setDescription('Test Invoice');

        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<SeznamFaktVyd>', $xml);
        $this->assertStringContainsString('<FaktVyd>', $xml);
        $this->assertStringContainsString('<Doklad>2023001</Doklad>', $xml);
        $this->assertStringContainsString('<Popis>Test Invoice</Popis>', $xml);
        $this->assertStringContainsString('</FaktVyd>', $xml);
        $this->assertStringContainsString('</SeznamFaktVyd>', $xml);
    }

    public function testGetXmlWithReceipts(): void
    {
        $receipt = $this->moneyS3->addReceipt();
        
        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<Prijemka>', $xml);
        $this->assertStringContainsString('</Prijemka>', $xml);
    }

    public function testMultipleInvoicesOfSameType(): void
    {
        $invoice1 = $this->moneyS3->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001');
        
        $invoice2 = $this->moneyS3->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023002');
        
        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<Doklad>2023001</Doklad>', $xml);
        $this->assertStringContainsString('<Doklad>2023002</Doklad>', $xml);
    }

    public function testMultipleInvoicesOfDifferentTypes(): void
    {
        $issuedInvoice = $this->moneyS3->addInvoice(InvoiceType::ISSUED);
        $issuedInvoice->setDocumentNumber('OUT001');
        
        $receivedInvoice = $this->moneyS3->addInvoice(InvoiceType::RECEIVED);
        $receivedInvoice->setDocumentNumber('IN001');
        
        $xml = $this->moneyS3->getXml();

        file_put_contents(__DIR__.'/../temp/moneyS3_output.xml', $xml);
        
        $this->assertStringContainsString('<SeznamFaktVyd>', $xml);
        $this->assertStringContainsString('<SeznamFaktPrij>', $xml);
        $this->assertStringContainsString('<Doklad>OUT001</Doklad>', $xml);
        $this->assertStringContainsString('<Doklad>IN001</Doklad>', $xml);
    }

    public function testXmlValidatesAsWellFormedXml(): void
    {
        $this->moneyS3->addInvoice(InvoiceType::ISSUED);
        $this->moneyS3->addReceipt();
        
        $xml = $this->moneyS3->getXml();
        
        // Test that XML is well-formed by trying to parse it
        $dom = new \DOMDocument();
        $result = $dom->loadXML($xml);
        
        $this->assertTrue($result, 'Generated XML should be well-formed');
    }

    public function testSample(): void
    {
        $this->moneyS3->addInvoice(InvoiceType::ISSUED)
            ->setDocumentNumber('VF2025090001')
            ->setAccountingMethod(1)
            ->setDescription('test')
            ->setIssued(new \DateTime('2025-09-08'))
            ->setAccountingDate(new \DateTime('2025-09-08'))
            ->setTaxDocumentDate(new DateTime('2025-09-08'))
            ->setDueDate(new \DateTime('2025-09-22'))
            ->setSimplified(false)
            ->setVariableSymbol('2025090001')
            ->setAccount('BAN')
            ->setType('N')
            ->setCreditNote(false)
            ->setVatRate1(12)
            ->setVatRate2(21)
            ->setToPay(1000)
            ->setSettled(false)
            ->setVatSummary(
                (new VatSummary())
                    ->setBase22(826.45)
                    ->setVat22(173.55)
            )
            ->setTotal(1000)
            ->setPartner(
                (new Partner())
                    ->setName('Jan Novák')
                    ->setAddress((new Address())
                        ->setStreet('Hlavní 123')
                        ->setCity('Praha')
                        ->setPostalCode('11000')
                        ->setCountry('Česká republika')
                        ->setCountryCode('CZ')
                    )
                    ->setIco('12345678')
                    ->setVatPayer(false)
                    ->setPhysicalPerson(true)
            )
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Firma s.r.o.')
                    ->setInvoiceAddress(
                        (new Address())
                            ->setStreet('Náměstí 1')
                            ->setCity('Brno')
                            ->setPostalCode('60200')
                            ->setCountry('Česká republika')
                            ->setCountryCode('CZ')
                    )
                    ->setIco('87654321')
                    ->setDic('CZ87654321')
                    ->setPhysicalPerson(false)
                    ->setCurrencySymbol('Kč')
                    ->setCurrencyCode('CZK')
            );

        $xml = $this->moneyS3->getXml();
        file_put_contents(__DIR__.'/../temp/test_sample_output.xml', $xml);
        $this->assertNotEmpty($xml);
    }
}
