<?php

namespace eProduct\MoneyS3\Test;

use DateTime;
use eProduct\MoneyS3\Document\Accounting\AccountingDocumentType;
use eProduct\MoneyS3\Document\Order\OrderType;
use eProduct\MoneyS3\Document\Warehouse\WarehouseType;
use eProduct\MoneyS3\MoneyS3;
use PHPUnit\Framework\TestCase;

class MoneyS3NewDocumentTypesTest extends TestCase
{
    private MoneyS3 $moneyS3;

    protected function setUp(): void
    {
        $this->moneyS3 = new MoneyS3('12345678');
    }

    public function testAddOrder(): void
    {
        $order = $this->moneyS3->addOrder(OrderType::RECEIVED);
        $order->setDocumentNumber('OBJ001')
              ->setDescription('Test order')
              ->setTotal(1000.00);

        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<MoneyData ICAgendy="12345678"', $xml);
        $this->assertStringContainsString('<SeznamObjPrij>', $xml);
        $this->assertStringContainsString('<ObjPrij>', $xml);
        $this->assertStringContainsString('<Doklad>OBJ001</Doklad>', $xml);
        $this->assertStringContainsString('</ObjPrij>', $xml);
        $this->assertStringContainsString('</SeznamObjPrij>', $xml);
    }

    public function testAddIssuedOrder(): void
    {
        $order = $this->moneyS3->addOrder(OrderType::ISSUED);
        $order->setDocumentNumber('OBJ002');

        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<SeznamObjVyd>', $xml);
        $this->assertStringContainsString('<ObjVyd>', $xml);
        $this->assertStringContainsString('<Doklad>OBJ002</Doklad>', $xml);
    }

    public function testAddWarehouseDocument(): void
    {
        $warehouse = $this->moneyS3->addWarehouseDocument(WarehouseType::RECEIPT);
        $warehouse->setDocumentNumber('PRI001')
                 ->setTotal(1500.00);

        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<SeznamPrijemka>', $xml);
        $this->assertStringContainsString('<Prijemka>', $xml);
        $this->assertStringContainsString('<CisloDokla>PRI001</CisloDokla>', $xml);
        $this->assertStringContainsString('</Prijemka>', $xml);
        $this->assertStringContainsString('</SeznamPrijemka>', $xml);
    }

    public function testAddWarehouseIssue(): void
    {
        $warehouse = $this->moneyS3->addWarehouseDocument(WarehouseType::ISSUE);
        $warehouse->setDocumentNumber('VYD001');

        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<SeznamVydejka>', $xml);
        $this->assertStringContainsString('<Vydejka>', $xml);
        $this->assertStringContainsString('<CisloDokla>VYD001</CisloDokla>', $xml);
    }

    public function testAddInternalDocument(): void
    {
        $internal = $this->moneyS3->addInternalDocument();
        $internal->setDocumentNumber('INT001')
                ->setDescription('Internal entry');

        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<SeznamIntDokl>', $xml);
        $this->assertStringContainsString('<IntDokl>', $xml);
        $this->assertStringContainsString('<Doklad>INT001</Doklad>', $xml);
        $this->assertStringContainsString('</IntDokl>', $xml);
        $this->assertStringContainsString('</SeznamIntDokl>', $xml);
    }

    public function testAddAccountingDocument(): void
    {
        $accounting = $this->moneyS3->addAccountingDocument(AccountingDocumentType::BANK_DOCUMENT);
        $accounting->setDocumentNumber('BAN001')
                  ->setTotal(2500.00);

        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<SeznamBanDokl>', $xml);
        $this->assertStringContainsString('<BanDokl>', $xml);
        $this->assertStringContainsString('<Doklad>BAN001</Doklad>', $xml);
        $this->assertStringContainsString('</BanDokl>', $xml);
        $this->assertStringContainsString('</SeznamBanDokl>', $xml);
    }

    public function testAddCashDocument(): void
    {
        $cash = $this->moneyS3->addAccountingDocument(AccountingDocumentType::CASH_DOCUMENT);
        $cash->setDocumentNumber('POK001');

        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<SeznamPokDokl>', $xml);
        $this->assertStringContainsString('<PokDokl>', $xml);
        $this->assertStringContainsString('<Doklad>POK001</Doklad>', $xml);
    }

    public function testAddInventoryDocument(): void
    {
        $inventory = $this->moneyS3->addInventoryDocument();
        $inventory->setDocumentNumber(123)
                 ->setInventoryId(456);

        $xml = $this->moneyS3->getXml();
        
        $this->assertStringContainsString('<SeznamInvDokl>', $xml);
        $this->assertStringContainsString('<InvDokl>', $xml);
        $this->assertStringContainsString('<CisloD>123</CisloD>', $xml);
        $this->assertStringContainsString('<InvID>456</InvID>', $xml);
        $this->assertStringContainsString('</InvDokl>', $xml);
        $this->assertStringContainsString('</SeznamInvDokl>', $xml);
    }

    public function testMultipleDocumentTypes(): void
    {
        // Add various document types
        $this->moneyS3->addOrder(OrderType::RECEIVED)
                     ->setDocumentNumber('OBJ001');
        
        $this->moneyS3->addWarehouseDocument(WarehouseType::RECEIPT)
                     ->setDocumentNumber('PRI001');
        
        $this->moneyS3->addAccountingDocument(AccountingDocumentType::BANK_DOCUMENT)
                     ->setDocumentNumber('BAN001');

        $xml = $this->moneyS3->getXml();
        
        // Check that all document types are present
        $this->assertStringContainsString('<SeznamObjPrij>', $xml);
        $this->assertStringContainsString('<SeznamPrijemka>', $xml);
        $this->assertStringContainsString('<SeznamBanDokl>', $xml);
        
        // Check document numbers
        $this->assertStringContainsString('<Doklad>OBJ001</Doklad>', $xml);
        $this->assertStringContainsString('<CisloDokla>PRI001</CisloDokla>', $xml);
        $this->assertStringContainsString('<Doklad>BAN001</Doklad>', $xml);
    }

    public function testAddDocumentRawMethods(): void
    {
        // Test raw document addition methods
        $order = $this->moneyS3->addOrder(OrderType::RECEIVED);
        $order->setDocumentNumber('OBJ001');
        
        $warehouse = $this->moneyS3->addWarehouseDocument(WarehouseType::RECEIPT);
        $warehouse->setDocumentNumber('PRI001');
        
        $internal = $this->moneyS3->addInternalDocument();
        $internal->setDocumentNumber('INT001');
        
        $accounting = $this->moneyS3->addAccountingDocument(AccountingDocumentType::BANK_DOCUMENT);
        $accounting->setDocumentNumber('BAN001');
        
        $inventory = $this->moneyS3->addInventoryDocument();
        $inventory->setDocumentNumber(123)->setInventoryId(456);

        // Test adding via raw methods
        $this->moneyS3->addOrderRaw($order);
        $this->moneyS3->addWarehouseDocumentRaw($warehouse);
        $this->moneyS3->addInternalDocumentRaw($internal);
        $this->moneyS3->addAccountingDocumentRaw($accounting);
        $this->moneyS3->addInventoryDocumentRaw($inventory);

        $xml = $this->moneyS3->getXml();
        
        // Should contain documents twice (once from add*, once from addRaw*)
        $this->assertEquals(2, substr_count($xml, '<Doklad>OBJ001</Doklad>'));
        $this->assertEquals(2, substr_count($xml, '<CisloDokla>PRI001</CisloDokla>'));
        $this->assertEquals(2, substr_count($xml, '<Doklad>INT001</Doklad>'));
        $this->assertEquals(2, substr_count($xml, '<Doklad>BAN001</Doklad>'));
        $this->assertEquals(2, substr_count($xml, '<CisloD>123</CisloD>'));
    }

    public function testXmlStructureWithAllDocumentTypes(): void
    {
        // Add one of each document type
        $this->moneyS3->addOrder(OrderType::RECEIVED)->setDocumentNumber('OBJ001');
        $this->moneyS3->addOrder(OrderType::ISSUED)->setDocumentNumber('OBJ002');
        $this->moneyS3->addWarehouseDocument(WarehouseType::RECEIPT)->setDocumentNumber('PRI001');
        $this->moneyS3->addWarehouseDocument(WarehouseType::ISSUE)->setDocumentNumber('VYD001');
        $this->moneyS3->addInternalDocument()->setDocumentNumber('INT001');
        $this->moneyS3->addAccountingDocument(AccountingDocumentType::BANK_DOCUMENT)->setDocumentNumber('BAN001');
        $this->moneyS3->addAccountingDocument(AccountingDocumentType::CASH_DOCUMENT)->setDocumentNumber('POK001');
        $this->moneyS3->addInventoryDocument()->setDocumentNumber(123)->setInventoryId(456);

        $xml = $this->moneyS3->getXml();
        
        // Check root structure
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $xml);
        $this->assertStringContainsString('<MoneyData ICAgendy="12345678" JazykVerze="CZ">', $xml);
        $this->assertStringEndsWith('</MoneyData>', $xml);
        
        // Verify well-formed XML
        $dom = new \DOMDocument();
        $this->assertTrue($dom->loadXML($xml), 'Generated XML should be well-formed');
    }
}
