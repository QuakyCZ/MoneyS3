<?php

declare(strict_types=1);

namespace eProduct\MoneyS3\Agenda;

use eProduct\MoneyS3\Exception\MoneyS3Exception;

enum EAgenda: string
{
    //case INVOICES_RECEIVED_FROM_SUPPLIER = '_FP';
    case INVOICES_ISSUED_AND_RECEIVED = '_FP+FV';
    case RECEIPTS = '_PD';
    case RECEIVABLES_AND_PAYABLES = '_PH+ZV';


    public function getClassName(): string
    {
        return match ($this) {
            //self::INVOICES_RECEIVED_FROM_SUPPLIER => InvoiceAgenda::class,
            self::INVOICES_ISSUED_AND_RECEIVED => InvoiceAgenda::class,
            self::RECEIPTS => ReceiptAgenda::class,
            self::RECEIVABLES_AND_PAYABLES => ObligationAgenda::class,
        };
    }
}
