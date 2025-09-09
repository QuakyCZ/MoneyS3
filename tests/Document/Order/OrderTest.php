<?php

namespace eProduct\MoneyS3\Test\Document\Order;

use DateTime;
use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Document\Order\Order;
use eProduct\MoneyS3\Document\Order\OrderItem;
use eProduct\MoneyS3\Document\Order\OrderType;
use PHPUnit\Framework\TestCase;
use XMLWriter;

class OrderTest extends TestCase
{
    private Order $order;

    protected function setUp(): void
    {
        $this->order = new Order(OrderType::RECEIVED);
    }

    public function testConstructorSetsOrderType(): void
    {
        $this->assertEquals(OrderType::RECEIVED, $this->order->orderType);
    }

    public function testSetDocumentNumber(): void
    {
        $result = $this->order->setDocumentNumber('OBJ001');
        $this->assertSame($this->order, $result);
    }

    public function testSetDescription(): void
    {
        $result = $this->order->setDescription('Test order');
        $this->assertSame($this->order, $result);
    }

    public function testSetIssued(): void
    {
        $date = new DateTime('2023-01-01');
        $result = $this->order->setIssued($date);
        $this->assertSame($this->order, $result);
    }

    public function testSetDueDate(): void
    {
        $date = new DateTime('2023-01-31');
        $result = $this->order->setDueDate($date);
        $this->assertSame($this->order, $result);
    }

    public function testSetVariableSymbol(): void
    {
        $result = $this->order->setVariableSymbol('123456');
        $this->assertSame($this->order, $result);
    }

    public function testSetVatRate1(): void
    {
        $result = $this->order->setVatRate1(21);
        $this->assertSame($this->order, $result);
    }

    public function testSetTotal(): void
    {
        $result = $this->order->setTotal(1000.50);
        $this->assertSame($this->order, $result);
    }

    public function testSetNote(): void
    {
        $result = $this->order->setNote('Test note');
        $this->assertSame($this->order, $result);
    }

    public function testSetPartner(): void
    {
        $result = $this->order->setPartner('Partner ABC');
        $this->assertSame($this->order, $result);
    }

    public function testSerializeWithMinimalData(): void
    {
        $this->order->setDocumentNumber('OBJ001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $this->order->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<ObjPrij>', $xml);
        $this->assertStringContainsString('<Doklad>OBJ001</Doklad>', $xml);
        $this->assertStringContainsString('</ObjPrij>', $xml);
    }

    public function testSerializeWithAllFields(): void
    {
        $issued = new DateTime('2023-01-01');
        $dueDate = new DateTime('2023-01-31');
        
        $this->order
            ->setDocumentNumber('OBJ001')
            ->setDescription('Test Order')
            ->setIssued($issued)
            ->setDueDate($dueDate)
            ->setVariableSymbol('123456')
            ->setVatRate1(21)
            ->setTotal(1000.00)
            ->setNote('Test note');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $this->order->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<ObjPrij>', $xml);
        $this->assertStringContainsString('<Doklad>OBJ001</Doklad>', $xml);
        $this->assertStringContainsString('<Popis>Test Order</Popis>', $xml);
        $this->assertStringContainsString('<Vystaveno>2023-01-01</Vystaveno>', $xml);
        $this->assertStringContainsString('<Vyridit_do>2023-01-31</Vyridit_do>', $xml);
        $this->assertStringContainsString('<VarSymbol>123456</VarSymbol>', $xml);
        $this->assertStringContainsString('<SazbaDPH1>21</SazbaDPH1>', $xml);
        $this->assertStringContainsString('<Celkem>1000</Celkem>', $xml);
        $this->assertStringContainsString('<Poznamka>Test note</Poznamka>', $xml);
        $this->assertStringContainsString('</ObjPrij>', $xml);
    }

    public function testSerializeIssuedOrder(): void
    {
        $order = new Order(OrderType::ISSUED);
        $order->setDocumentNumber('OBJ002');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $order->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<ObjVyd>', $xml);
        $this->assertStringContainsString('<Doklad>OBJ002</Doklad>', $xml);
        $this->assertStringContainsString('</ObjVyd>', $xml);
    }

    public function testSerializeOffer(): void
    {
        $order = new Order(OrderType::OFFER_RECEIVED);
        $order->setDocumentNumber('NAB001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $order->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<NabPrij>', $xml);
        $this->assertStringContainsString('<Doklad>NAB001</Doklad>', $xml);
        $this->assertStringContainsString('</NabPrij>', $xml);
    }

    public function testSerializeInquiry(): void
    {
        $order = new Order(OrderType::INQUIRY_ISSUED);
        $order->setDocumentNumber('POP001');
        
        $writer = new XMLWriter();
        $writer->openMemory();
        $order->serialize($writer);
        
        $xml = $writer->outputMemory();
        $this->assertStringContainsString('<PoptVyd>', $xml);
        $this->assertStringContainsString('<Doklad>POP001</Doklad>', $xml);
        $this->assertStringContainsString('</PoptVyd>', $xml);
    }
}
