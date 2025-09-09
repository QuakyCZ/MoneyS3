<?php

namespace eProduct\MoneyS3\Test\Document\Warehouse;

use eProduct\MoneyS3\Document\Warehouse\WarehouseType;
use PHPUnit\Framework\TestCase;

class WarehouseTypeTest extends TestCase
{
    public function testAllWarehouseTypeValues(): void
    {
        $this->assertEquals('receipt', WarehouseType::RECEIPT->value);
        $this->assertEquals('issue', WarehouseType::ISSUE->value);
        $this->assertEquals('delivery_note_received', WarehouseType::DELIVERY_NOTE_RECEIVED->value);
        $this->assertEquals('delivery_note_issued', WarehouseType::DELIVERY_NOTE_ISSUED->value);
        $this->assertEquals('sales_receipt', WarehouseType::SALES_RECEIPT->value);
        $this->assertEquals('transfer', WarehouseType::TRANSFER->value);
        $this->assertEquals('production', WarehouseType::PRODUCTION->value);
    }

    public function testGetRootElement(): void
    {
        $this->assertEquals('Prijemka', WarehouseType::RECEIPT->getRootElement());
        $this->assertEquals('Vydejka', WarehouseType::ISSUE->getRootElement());
        $this->assertEquals('DLPrij', WarehouseType::DELIVERY_NOTE_RECEIVED->getRootElement());
        $this->assertEquals('DLVyd', WarehouseType::DELIVERY_NOTE_ISSUED->getRootElement());
        $this->assertEquals('Prodejka', WarehouseType::SALES_RECEIPT->getRootElement());
        $this->assertEquals('Prevodka', WarehouseType::TRANSFER->getRootElement());
        $this->assertEquals('Vyrobka', WarehouseType::PRODUCTION->getRootElement());
    }

    public function testGetListRootElement(): void
    {
        $this->assertEquals('SeznamPrijemka', WarehouseType::RECEIPT->getListRootElement());
        $this->assertEquals('SeznamVydejka', WarehouseType::ISSUE->getListRootElement());
        $this->assertEquals('SeznamDLPrij', WarehouseType::DELIVERY_NOTE_RECEIVED->getListRootElement());
        $this->assertEquals('SeznamDLVyd', WarehouseType::DELIVERY_NOTE_ISSUED->getListRootElement());
        $this->assertEquals('SeznamProdejka', WarehouseType::SALES_RECEIPT->getListRootElement());
        $this->assertEquals('SeznamPrevodka', WarehouseType::TRANSFER->getListRootElement());
        $this->assertEquals('SeznamVyrobka', WarehouseType::PRODUCTION->getListRootElement());
    }

    public function testFromString(): void
    {
        $this->assertEquals(WarehouseType::RECEIPT, WarehouseType::from('receipt'));
        $this->assertEquals(WarehouseType::ISSUE, WarehouseType::from('issue'));
        $this->assertEquals(WarehouseType::DELIVERY_NOTE_RECEIVED, WarehouseType::from('delivery_note_received'));
        $this->assertEquals(WarehouseType::DELIVERY_NOTE_ISSUED, WarehouseType::from('delivery_note_issued'));
        $this->assertEquals(WarehouseType::SALES_RECEIPT, WarehouseType::from('sales_receipt'));
        $this->assertEquals(WarehouseType::TRANSFER, WarehouseType::from('transfer'));
        $this->assertEquals(WarehouseType::PRODUCTION, WarehouseType::from('production'));
    }
}
