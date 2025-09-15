<?php

namespace eProduct\MoneyS3\Test\XmlDiff;

use eProduct\MoneyS3\Document\Invoice\Company;
use eProduct\MoneyS3\Document\Receipt\ReceiptType;
use eProduct\MoneyS3\MoneyS3;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Test\Utility\XmlTestUtility;
use PHPUnit\Framework\TestCase;


class MoneyS3XmlDiffTest extends TestCase
{
    private MoneyS3 $moneyS3;
    private string $testIco;

    protected function setUp(): void
    {
        $this->testIco = '12345678';
        $this->moneyS3 = new MoneyS3($this->testIco);
    }

    public function testXmlDiffEmptyDocuments(): void
    {
        $xml1 = $this->moneyS3->getXmls();
        $xml2 = (new MoneyS3($this->testIco))->getXmls();

        // Should be identical
        $comparison = XmlTestUtility::compareXml($xml1, $xml2);
        $this->assertTrue($comparison['identical']);
        
        // System diff should show no differences
        $systemDiff = XmlTestUtility::xmlDiffSystem($xml1, $xml2);
        print_r($systemDiff);
        $this->assertFalse($systemDiff['has_differences']);
    }

    public function testXmlDiffSingleInvoiceAddition(): void
    {
        $moneyS3WithInvoice = new MoneyS3($this->testIco);
        $invoice = $moneyS3WithInvoice->addInvoice(InvoiceType::ISSUED);
        $invoice->setDocumentNumber('2023001')
            ->setMyCompany(
                (new \eProduct\MoneyS3\Document\Invoice\Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        $emptyXml = $this->moneyS3->getXmls();
        $withInvoiceXml = $moneyS3WithInvoice->getXmls();

        // Should be different
        $comparison = XmlTestUtility::compareXml($emptyXml, $withInvoiceXml);
        $this->assertFalse($comparison['normalized_identical']);
        $this->assertNotEmpty($comparison['differences']);

        // Check specific differences
        $differencesText = implode(' ', $comparison['differences']);
        $this->assertStringContainsString('SeznamFaktVyd', $differencesText);

        // System diff should show differences
        $systemDiff = XmlTestUtility::xmlDiffSystem($emptyXml, $withInvoiceXml);
        $this->assertTrue($systemDiff['has_differences']);
    }

    public function testXmlDiffInvoiceModification(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001')
            ->setDescription('Original Description')
            ->setMyCompany(
                (new \eProduct\MoneyS3\Document\Invoice\Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023001')
            ->setDescription('Modified Description')
            ->setMyCompany(
                (new \eProduct\MoneyS3\Document\Invoice\Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        $xml1 = $moneyS31->getXmls();
        $xml2 = $moneyS32->getXmls();

        // Should have same structure but different content
        $comparison = XmlTestUtility::compareXml($xml1, $xml2);
        $this->assertTrue($comparison['structural_identical']);
        $this->assertFalse($comparison['normalized_identical']);

        // Should show specific text difference
        $differencesText = implode(' ', $comparison['differences']);
        $this->assertStringContainsString('Original Description', $differencesText);
        $this->assertStringContainsString('Modified Description', $differencesText);
    }

    public function testXmlDiffMultipleInvoiceTypes(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $moneyS31->addInvoice(InvoiceType::ISSUED)
            ->setDocumentNumber('OUT001')
            ->setMyCompany(
                (new \eProduct\MoneyS3\Document\Invoice\Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        $moneyS32 = new MoneyS3($this->testIco);
        $moneyS32->addInvoice(InvoiceType::RECEIVED)
            ->setDocumentNumber('IN001')
            ->setMyCompany(
                (new \eProduct\MoneyS3\Document\Invoice\Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        $xml1 = $moneyS31->getXmls();
        $xml2 = $moneyS32->getXmls();

        $comparison = XmlTestUtility::compareXml($xml1, $xml2);
        $this->assertFalse($comparison['structural_identical']);

        // Check that differences mention both invoice types
        $differencesText = implode(' ', $comparison['differences']);
        $this->assertStringContainsString('SeznamFaktVyd', $differencesText);
        $this->assertStringContainsString('SeznamFaktPrij', $differencesText);
    }

    public function testXmlDiffAttributeChanges(): void
    {
        $moneyS31 = new MoneyS3('11111111');
        $moneyS32 = new MoneyS3('22222222');

        $xml1 = $moneyS31->getXmls();
        $xml2 = $moneyS32->getXmls();

        $comparison = XmlTestUtility::compareXml($xml1, $xml2);
        $this->assertFalse($comparison['normalized_identical']);

        // Should detect ICO attribute difference
        $differencesText = implode(' ', $comparison['differences']);
        $this->assertStringContainsString('ICAgendy', $differencesText);
        $this->assertStringContainsString('11111111', $differencesText);
        $this->assertStringContainsString('22222222', $differencesText);
    }

    public function testXmlDiffReceiptAddition(): void
    {
        $moneyS3WithReceipt = new MoneyS3($this->testIco);
        $moneyS3WithReceipt->addReceipt(ReceiptType::EXPENSE);

        $emptyXml = $this->moneyS3->getXmls();
        $withReceiptXml = $moneyS3WithReceipt->getXmls();

        $comparison = XmlTestUtility::compareXml($emptyXml, $withReceiptXml);
        $this->assertFalse($comparison['normalized_identical']);

        // Should detect receipt addition
        $differencesText = implode(' ', $comparison['differences']);
        $this->assertStringContainsString('SeznamPokDokl', $differencesText);
    }

    public function testXmlDiffComplexDocument(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001')
            ->setDescription('Invoice 1')
            ->setTotal(1000.00)
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
            );
        $moneyS31->addReceipt(ReceiptType::EXPENSE);

        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023002')  // Different number
        ->setDescription('Invoice 1')   // Same description
        ->setTotal(2000.00)          // Different total
        ->setMyCompany(
            (new Company())
                ->setInvoiceName('Test Company')
        );
        $moneyS32->addReceipt(ReceiptType::EXPENSE);
        $moneyS32->addReceipt(ReceiptType::INCOME);  // Extra receipt

        $xml1 = $moneyS31->getXmls();
        $xml2 = $moneyS32->getXmls();

        $comparison = XmlTestUtility::compareXml($xml1, $xml2);
        $this->assertFalse($comparison['normalized_identical']);
        $this->assertFalse($comparison['structural_identical']); // Different structure due to extra receipt
        // $this->assertTrue($comparison['structural_identical']); // Same structure overall

        // Check specific differences
        $differencesText = implode(' ', $comparison['differences']);
        $this->assertStringContainsString('2023001', $differencesText);
        $this->assertStringContainsString('2023002', $differencesText);
        $this->assertStringContainsString('1000', $differencesText);
        $this->assertStringContainsString('2000', $differencesText);
    }

    public function testXmlAssertionSuccess(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
            );

        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023001')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
            );

        $xml1 = $moneyS31->getXmls();
        $xml2 = $moneyS32->getXmls();

        // Should not throw exception
        XmlTestUtility::assertXmlEquals($xml1, $xml2);
        $this->assertTrue(true); // @phpstan-ignore-line
    }

    public function testXmlAssertionFailure(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
            );

        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023002')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Another Company')
            );

        $xml1 = $moneyS31->getXmls();
        $xml2 = $moneyS32->getXmls();

        $this->expectException(\PHPUnit\Framework\AssertionFailedError::class);
        $this->expectExceptionMessage('XML documents are not equivalent');

        XmlTestUtility::assertXmlEquals($xml1, $xml2);
    }

    public function testXmlContainsAssertion(): void
    {
        $invoice = $this->moneyS3->addInvoice(InvoiceType::ISSUED);
        $invoice->setDocumentNumber('2023001')
            ->setDescription('Test Invoice')
            ->setTotal(1500.00)
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
            );

        $xml = $this->moneyS3->getXmls();

        // Should not throw exception
        XmlTestUtility::assertXmlContains($xml, [
            'MoneyData',
            'SeznamFaktVyd',
            'FaktVyd',
            'Doklad' => '2023001',
            'Popis' => 'Test Invoice',
            'Celkem' => '1500',
            'FaktNazev' => 'Test Company'
        ]);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    public function testXmlStructureAssertion(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001')
            ->setDescription('Invoice 1')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
                    ->setIco('12345678')
            );

        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023999')
            ->setDescription('Different Invoice')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Another Company')
                    ->setIco('87654321')
            );

        $xml1 = $moneyS31->getXmls();
        $xml2 = $moneyS32->getXmls();

        // Should not throw exception (same structure)
        XmlTestUtility::assertXmlStructureEquals($xml1, $xml2);
        $this->assertTrue(true); // @phpstan-ignore-line
    }

    public function testStatisticsGeneration(): void
    {
        $invoice = $this->moneyS3->addInvoice(InvoiceType::ISSUED);
        $invoice->setDocumentNumber('2023001')
            ->setDescription('Test Invoice')
            ->setTotal(1000.00)
            ->setVariableSymbol('123456')
            ->setMyCompany(
                (new Company())
                    ->setInvoiceName('Test Company')
            );

        $this->moneyS3->addReceipt(ReceiptType::EXPENSE);

        $emptyMoneyS3 = new MoneyS3($this->testIco);

        $fullXml = $this->moneyS3->getXmls();
        $emptyXml = $emptyMoneyS3->getXmls();

        $comparison = XmlTestUtility::compareXml($emptyXml, $fullXml);

        $this->assertArrayHasKey('statistics', $comparison);
        $stats = $comparison['statistics'];

        $this->assertArrayHasKey('elements_count_1', $stats);
        $this->assertArrayHasKey('elements_count_2', $stats);
        $this->assertGreaterThan($stats['elements_count_1'], $stats['elements_count_2']);
    }

    public function testSystemXmlDiffOutput(): void
    {
        $company1 = new Company();
        $company1->setInvoiceName('Company A');
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('OLD001');
        $invoice1->setMyCompany($company1);

        $company2 = new Company();
        $company2->setInvoiceName('Company B');
        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('NEW001');
        $invoice2->setMyCompany($company2);

        $xml1 = $moneyS31->getXmls();
        $xml2 = $moneyS32->getXmls();

        $systemDiff = XmlTestUtility::xmlDiffSystem($xml1, $xml2, ['formatter' => 'diff']);

        $this->assertTrue($systemDiff['has_differences']);
        $this->assertNotEmpty($systemDiff['output']);
        $this->assertStringContainsString('OLD001', $systemDiff['output']);
        $this->assertStringContainsString('NEW001', $systemDiff['output']);
        $this->assertStringContainsString('Company A', $systemDiff['output']);
        $this->assertStringContainsString('Company B', $systemDiff['output']);
    }
}
