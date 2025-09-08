<?php

namespace eprehled\MoneyS3;

use eprehled\MoneyS3\Document\Invoice\Invoice;
use eprehled\MoneyS3\Document\Receipt\Receipt;

/**
 * @internal
 */
class MoneyS3Data
{
    /** @var Invoice */
    public array $invoices = [];

    /** @var Receipt[] */
    public array $receipts = [];
}