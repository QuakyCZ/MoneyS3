<?php

namespace eProduct\MoneyS3\Document\Invoice;

enum InvoiceType: string
{
    case ISSUED = 'issued';
    case RECEIVED = 'received';

    /**
     * Gets the XML root element name for this invoice type
     *
     * @return string The XML element name for individual invoice
     */
    public function getRootElement(): string
    {
        return match($this) {
            self::ISSUED => 'FaktVyd',
            self::RECEIVED => 'FaktPrij',
        };
    }

    /**
     * Gets the XML list root element name for this invoice type
     *
     * @return string The XML element name for invoice list container
     */
    public function getListRootElement(): string
    {
        return match($this) {
            self::ISSUED => 'SeznamFaktVyd',
            self::RECEIVED => 'SeznamFaktPrij',
        };
    }
}
