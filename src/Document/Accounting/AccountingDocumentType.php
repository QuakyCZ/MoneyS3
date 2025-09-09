<?php

namespace eProduct\MoneyS3\Document\Accounting;

enum AccountingDocumentType: string
{
    case BANK_DOCUMENT = 'bank_document';       // SeznamBankDokl
    case CASH_DOCUMENT = 'cash_document';       // SeznamPokDokl

    /**
     * Gets the root XML element name for this accounting document type
     */
    public function getRootElement(): string
    {
        return match ($this) {
            self::BANK_DOCUMENT => 'BankDokl',
            self::CASH_DOCUMENT => 'PokDokl',
        };
    }

    /**
     * Gets the list root XML element name for this accounting document type
     */
    public function getListRootElement(): string
    {
        return match ($this) {
            self::BANK_DOCUMENT => 'SeznamBankDokl',
            self::CASH_DOCUMENT => 'SeznamPokDokl',
        };
    }
}
