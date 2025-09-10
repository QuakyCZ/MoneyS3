<?php

namespace eProduct\MoneyS3\Test;

use eProduct\MoneyS3\Agenda\InvoiceAgenda;
use eProduct\MoneyS3\Agenda\ReceiptAgenda;
use eProduct\MoneyS3\MoneyS3;
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

    public function testInvoiceAgenda(): void
    {
        $agenda = $this->moneyS3->getInvoiceAgenda();
        $this->assertNotNull($agenda);
        $this->assertInstanceOf(InvoiceAgenda::class, $agenda);
    }

    public function testReceiptAgenda(): void
    {
        $agenda = $this->moneyS3->getReceiptAgenda();
        $this->assertNotNull($agenda);
        $this->assertInstanceOf(ReceiptAgenda::class, $agenda);
    }
}
