<?php

namespace eProduct\MoneyS3\Test\Document\Order;

use eProduct\MoneyS3\Document\Order\OrderType;
use PHPUnit\Framework\TestCase;

class OrderTypeTest extends TestCase
{
    public function testAllOrderTypeValues(): void
    {
        $this->assertEquals('received', OrderType::RECEIVED->value);
        $this->assertEquals('issued', OrderType::ISSUED->value);
        $this->assertEquals('offer_received', OrderType::OFFER_RECEIVED->value);
        $this->assertEquals('offer_issued', OrderType::OFFER_ISSUED->value);
        $this->assertEquals('inquiry_received', OrderType::INQUIRY_RECEIVED->value);
        $this->assertEquals('inquiry_issued', OrderType::INQUIRY_ISSUED->value);
    }

    public function testGetRootElement(): void
    {
        $this->assertEquals('PoptPrij', OrderType::INQUIRY_RECEIVED->getRootElement());
        $this->assertEquals('ObjPrij', OrderType::RECEIVED->getRootElement());
        $this->assertEquals('NabVyd', OrderType::OFFER_ISSUED->getRootElement());
    }

    public function testGetListRootElement(): void
    {
        $this->assertEquals('SeznamPoptPrij', OrderType::INQUIRY_RECEIVED->getListRootElement());
        $this->assertEquals('SeznamObjPrij', OrderType::RECEIVED->getListRootElement());
        $this->assertEquals('SeznamNabVyd', OrderType::OFFER_ISSUED->getListRootElement());
    }

    public function testFromString(): void
    {
        $this->assertEquals(OrderType::RECEIVED, OrderType::from('received'));
        $this->assertEquals(OrderType::ISSUED, OrderType::from('issued'));
        $this->assertEquals(OrderType::OFFER_RECEIVED, OrderType::from('offer_received'));
        $this->assertEquals(OrderType::OFFER_ISSUED, OrderType::from('offer_issued'));
        $this->assertEquals(OrderType::INQUIRY_RECEIVED, OrderType::from('inquiry_received'));
        $this->assertEquals(OrderType::INQUIRY_ISSUED, OrderType::from('inquiry_issued'));
    }
}
