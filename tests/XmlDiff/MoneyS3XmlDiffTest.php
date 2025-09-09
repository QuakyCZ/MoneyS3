<?php

namespace eProduct\MoneyS3\Test\XmlDiff;

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
        $xml1 = $this->moneyS3->getXml();
        $xml2 = (new MoneyS3($this->testIco))->getXml();
        
        // Should be identical
        $comparison = XmlTestUtility::compareXml($xml1, $xml2);
        $this->assertTrue($comparison['normalized_identical']);
        
        // System diff should show no differences
        $systemDiff = XmlTestUtility::xmlDiffSystem($xml1, $xml2);
        $this->assertFalse($systemDiff['has_differences']);
    }

    public function testXmlDiffSingleInvoiceAddition(): void
    {
        $moneyS3WithInvoice = new MoneyS3($this->testIco);
        $invoice = $moneyS3WithInvoice->addInvoice(InvoiceType::ISSUED);
        $invoice->setDocumentNumber('2023001');
        
        $emptyXml = $this->moneyS3->getXml();
        $withInvoiceXml = $moneyS3WithInvoice->getXml();
        
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
        $invoice1->setDocumentNumber('2023001')->setDescription('Original Description');
        
        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023001')->setDescription('Modified Description');
        
        $xml1 = $moneyS31->getXml();
        $xml2 = $moneyS32->getXml();
        
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
        $moneyS31->addInvoice(InvoiceType::ISSUED)->setDocumentNumber('OUT001');
        
        $moneyS32 = new MoneyS3($this->testIco);
        $moneyS32->addInvoice(InvoiceType::RECEIVED)->setDocumentNumber('IN001');
        
        $xml1 = $moneyS31->getXml();
        $xml2 = $moneyS32->getXml();
        
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
        
        $xml1 = $moneyS31->getXml();
        $xml2 = $moneyS32->getXml();
        
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
        $moneyS3WithReceipt->addReceipt();
        
        $emptyXml = $this->moneyS3->getXml();
        $withReceiptXml = $moneyS3WithReceipt->getXml();
        
        $comparison = XmlTestUtility::compareXml($emptyXml, $withReceiptXml);
        $this->assertFalse($comparison['normalized_identical']);
        
        // Should detect receipt addition
        $differencesText = implode(' ', $comparison['differences']);
        $this->assertStringContainsString('Prijemka', $differencesText);
    }

    public function testXmlDiffComplexDocument(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001')
                 ->setDescription('Invoice 1')
                 ->setTotal('1000.00');
        $moneyS31->addReceipt();
        
        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023002')  // Different number
                 ->setDescription('Invoice 1')   // Same description
                 ->setTotal('2000.00');          // Different total
        $moneyS32->addReceipt();
        $moneyS32->addReceipt();  // Extra receipt
        
        $xml1 = $moneyS31->getXml();
        $xml2 = $moneyS32->getXml();
        
        $comparison = XmlTestUtility::compareXml($xml1, $xml2);
        $this->assertFalse($comparison['normalized_identical']);
        $this->assertTrue($comparison['structural_identical']); // Same structure overall
        
        // Check specific differences
        $differencesText = implode(' ', $comparison['differences']);
        $this->assertStringContainsString('2023001', $differencesText);
        $this->assertStringContainsString('2023002', $differencesText);
        $this->assertStringContainsString('1000.00', $differencesText);
        $this->assertStringContainsString('2000.00', $differencesText);
    }

    public function testXmlAssertionSuccess(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001');
        
        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023001');
        
        $xml1 = $moneyS31->getXml();
        $xml2 = $moneyS32->getXml();
        
        // Should not throw exception
        XmlTestUtility::assertXmlEquals($xml1, $xml2);
        $this->assertTrue(true);
    }

    public function testXmlAssertionFailure(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001');
        
        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023002');
        
        $xml1 = $moneyS31->getXml();
        $xml2 = $moneyS32->getXml();
        
        $this->expectException(\PHPUnit\Framework\AssertionFailedError::class);
        $this->expectExceptionMessage('XML documents are not equivalent');
        
        XmlTestUtility::assertXmlEquals($xml1, $xml2);
    }

    public function testXmlContainsAssertion(): void
    {
        $invoice = $this->moneyS3->addInvoice(InvoiceType::ISSUED);
        $invoice->setDocumentNumber('2023001')
                ->setDescription('Test Invoice')
                ->setTotal('1500.00');
        
        $xml = $this->moneyS3->getXml();
        
        // Should not throw exception
        XmlTestUtility::assertXmlContains($xml, [
            'MoneyData',
            'SeznamFaktVyd',
            'FaktVyd',
            'Doklad' => '2023001',
            'Popis' => 'Test Invoice',
            'Celkem' => '1500.00'
        ]);
        
        $this->assertTrue(true);
    }

    public function testXmlStructureAssertion(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('2023001')->setDescription('Invoice 1');
        
        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('2023999')->setDescription('Different Invoice');
        
        $xml1 = $moneyS31->getXml();
        $xml2 = $moneyS32->getXml();
        
        // Should not throw exception (same structure)
        XmlTestUtility::assertXmlStructureEquals($xml1, $xml2);
        $this->assertTrue(true);
    }

    public function testStatisticsGeneration(): void
    {
        $invoice = $this->moneyS3->addInvoice(InvoiceType::ISSUED);
        $invoice->setDocumentNumber('2023001')
                ->setDescription('Test Invoice')
                ->setTotal('1000.00')
                ->setVariableSymbol('123456');
        $this->moneyS3->addReceipt();
        
        $emptyMoneyS3 = new MoneyS3($this->testIco);
        
        $fullXml = $this->moneyS3->getXml();
        $emptyXml = $emptyMoneyS3->getXml();
        
        $comparison = XmlTestUtility::compareXml($emptyXml, $fullXml);
        
        $this->assertArrayHasKey('statistics', $comparison);
        $stats = $comparison['statistics'];
        
        $this->assertArrayHasKey('elements_count_1', $stats);
        $this->assertArrayHasKey('elements_count_2', $stats);
        $this->assertGreaterThan($stats['elements_count_1'], $stats['elements_count_2']);
    }

    public function testSystemXmlDiffOutput(): void
    {
        $moneyS31 = new MoneyS3($this->testIco);
        $invoice1 = $moneyS31->addInvoice(InvoiceType::ISSUED);
        $invoice1->setDocumentNumber('OLD001');
        
        $moneyS32 = new MoneyS3($this->testIco);
        $invoice2 = $moneyS32->addInvoice(InvoiceType::ISSUED);
        $invoice2->setDocumentNumber('NEW001');
        
        $xml1 = $moneyS31->getXml();
        $xml2 = $moneyS32->getXml();
        
        $systemDiff = XmlTestUtility::xmlDiffSystem($xml1, $xml2, ['formatter' => 'diff']);
        
        $this->assertTrue($systemDiff['has_differences']);
        $this->assertNotEmpty($systemDiff['output']);
        $this->assertStringContainsString('OLD001', $systemDiff['output']);
        $this->assertStringContainsString('NEW001', $systemDiff['output']);
    }
}
