<?php

namespace eprehled\MoneyS3\Document\Invoice;

enum InvoiceType: string
{
    case ISSUED = 'issued';
    case RECEIVED = 'received';
}
