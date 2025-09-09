<?php

namespace eProduct\MoneyS3\Document\Receipt;

use eProduct\MoneyS3\Document\IDocument;
use XMLWriter;

class Receipt implements IDocument
{
    /**
     * Serializes the receipt to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('Prijemka');
        $writer->text(''); // Force non-self-closing tag
        $writer->endElement();
    }
}