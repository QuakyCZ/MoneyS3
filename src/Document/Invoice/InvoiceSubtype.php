<?php

namespace eProduct\MoneyS3\Document\Invoice;

enum InvoiceSubtype: string
{
    case NORMAL = 'N';
    case PROFORMA = 'F';
    case ADVANCE = 'L';
    case TAX_DOCUMENT_FOR_PAYMENT = 'D';
}
