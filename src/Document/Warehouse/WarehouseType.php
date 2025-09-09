<?php

namespace eProduct\MoneyS3\Document\Warehouse;

enum WarehouseType: string
{
    case RECEIPT = 'receipt';                  // SeznamPrijemka
    case ISSUE = 'issue';                      // SeznamVydejka
    case DELIVERY_NOTE_RECEIVED = 'delivery_note_received';  // SeznamDLPrij
    case DELIVERY_NOTE_ISSUED = 'delivery_note_issued';      // SeznamDLVyd
    case SALES_RECEIPT = 'sales_receipt';      // SeznamProdejka
    case TRANSFER = 'transfer';                // SeznamPrevodka
    case PRODUCTION = 'production';            // SeznamVyrobka

    /**
     * Gets the root XML element name for this warehouse document type
     */
    public function getRootElement(): string
    {
        return match ($this) {
            self::RECEIPT => 'Prijemka',
            self::ISSUE => 'Vydejka',
            self::DELIVERY_NOTE_RECEIVED => 'DLPrij',
            self::DELIVERY_NOTE_ISSUED => 'DLVyd',
            self::SALES_RECEIPT => 'Prodejka',
            self::TRANSFER => 'Prevodka',
            self::PRODUCTION => 'Vyrobka',
        };
    }

    /**
     * Gets the list root XML element name for this warehouse document type
     */
    public function getListRootElement(): string
    {
        return match ($this) {
            self::RECEIPT => 'SeznamPrijemka',
            self::ISSUE => 'SeznamVydejka',
            self::DELIVERY_NOTE_RECEIVED => 'SeznamDLPrij',
            self::DELIVERY_NOTE_ISSUED => 'SeznamDLVyd',
            self::SALES_RECEIPT => 'SeznamProdejka',
            self::TRANSFER => 'SeznamPrevodka',
            self::PRODUCTION => 'SeznamVyrobka',
        };
    }
}
