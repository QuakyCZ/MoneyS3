<?php

namespace eProduct\MoneyS3\Document\Invoice;

enum InvoiceType: string
{
    case ISSUED = 'issued';
    case RECEIVED = 'received';

    public function getRootElement(): string {
        return match($this) {
            self::ISSUED => 'FaktVyd',
            self::RECEIVED => 'FaktPrij',
        };
    }

    public function getListRootElement(): string {
        return match($this) {
            self::ISSUED => 'SeznamFaktVyd',
            self::RECEIVED => 'SeznamFaktPrij',
        };
    }
}
