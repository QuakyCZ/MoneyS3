<?php

declare(strict_types=1);

namespace eProduct\MoneyS3\Test\Agenda;

use eProduct\MoneyS3\Agenda\AgendaFactory;
use eProduct\MoneyS3\Agenda\EAgenda;
use eProduct\MoneyS3\Agenda\IAgenda;
use eProduct\MoneyS3\Agenda\InvoiceAgenda;
use eProduct\MoneyS3\Agenda\ReceiptAgenda;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Document\Receipt\ReceiptType;
use eProduct\MoneyS3\Exception\MoneyS3Exception;
use PHPUnit\Framework\TestCase;


class AgendaFactoryTest extends TestCase
{
    private AgendaFactory $agendaFactory;

    protected function setUp(): void
    {
        $this->agendaFactory = new AgendaFactory();
    }

    public function testConstructorCreatesInstancesFromEAgendaCases(): void
    {
        $this->assertIsArray($this->agendaFactory->instances);
        $this->assertNotEmpty($this->agendaFactory->instances);
    }

    public function testConstructorThrowsExceptionWhenClassDoesNotExist(): void
    {
        $this->expectException(MoneyS3Exception::class);
        $this->expectExceptionMessage("Agenda instance for 'NonExistentClass' does not exist");

        $this->agendaFactory->getInstance('NonExistentClass');
    }

    public function testGetInstanceReturnsCorrectInstance(): void
    {
        foreach (EAgenda::cases() as $agenda) {
            $className = $agenda->getClassName();
            $instance = $this->agendaFactory->getInstance($className);
            $this->assertInstanceOf(IAgenda::class, $instance);
            $this->assertInstanceOf($className, $instance);
        }
    }

    public function testGetInstanceThrowsExceptionForNonExistentInstance(): void
    {
        $this->expectException(MoneyS3Exception::class);
        $this->expectExceptionMessage("Agenda instance for 'NonExistentClass' does not exist");
        
        $this->agendaFactory->getInstance('NonExistentClass');
    }

    public function testHasInstanceReturnsTrueForExistingInstance(): void
    {
        foreach (EAgenda::cases() as $agenda) {
            $className = $agenda->getClassName();
            $this->assertTrue($this->agendaFactory->hasInstance($className));
        }
    }

    public function testHasInstanceReturnsFalseForNonExistentInstance(): void
    {
        $this->assertFalse($this->agendaFactory->hasInstance('NonExistentClass'));
    }

    public function testFlushInstancesCallsFlushOnAllInstances(): void
    {
        /** @var InvoiceAgenda $invoiceAgenda */
        $invoiceAgenda = $this->agendaFactory->getInstance(InvoiceAgenda::class);

        $invoiceAgenda->addInvoice(InvoiceType::ISSUED)
            ->setDocumentNumber('123');

        $invoiceAgenda->addInvoice(InvoiceType::RECEIVED)
            ->setDocumentNumber('321');

        $this->assertFalse($invoiceAgenda->isEmpty());

        /** @var ReceiptAgenda $receiptAgenda */
        $receiptAgenda = $this->agendaFactory->getInstance(EAgenda::RECEIPTS->getClassName());
        $receiptAgenda->addReceipt(ReceiptType::EXPENSE)
            ->setDocumentNumber('456');

        $this->assertFalse($receiptAgenda->isEmpty());

        // This test would require injecting mock instances into the factory
        // Implementation depends on your testing strategy
        $this->agendaFactory->flushInstances();

        $this->assertTrue($invoiceAgenda->isEmpty());
        $this->assertTrue($receiptAgenda->isEmpty());
    }

    public function testInstancesPropertyIsReadonly(): void
    {
        $reflection = new \ReflectionProperty(AgendaFactory::class, 'instances');
        $this->assertTrue($reflection->isReadOnly());
    }

    public function testFactoryCreatesSameInstanceForSameAgenda(): void
    {
        foreach (EAgenda::cases() as $agenda) {
            $className = $agenda->getClassName();
            $instance1 = $this->agendaFactory->getInstance($className);
            $instance2 = $this->agendaFactory->getInstance($className);
            $this->assertSame($instance1, $instance2);
        }
    }
}