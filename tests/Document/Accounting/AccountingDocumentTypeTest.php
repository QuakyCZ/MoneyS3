<?php

namespace eProduct\MoneyS3\Test\Document\Accounting;

use eProduct\MoneyS3\Document\Accounting\AccountingDocumentType;
use PHPUnit\Framework\TestCase;

class AccountingDocumentTypeTest extends TestCase
{
    public function testAllAccountingDocumentTypeValues(): void
    {
        $this->assertEquals('bank_document', AccountingDocumentType::BANK_DOCUMENT->value);
        $this->assertEquals('cash_document', AccountingDocumentType::CASH_DOCUMENT->value);
    }

    public function testFromString(): void
    {
        $this->assertEquals(AccountingDocumentType::BANK_DOCUMENT, AccountingDocumentType::from('bank_document'));
        $this->assertEquals(AccountingDocumentType::CASH_DOCUMENT, AccountingDocumentType::from('cash_document'));
    }
}
