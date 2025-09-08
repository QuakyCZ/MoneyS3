<?php

namespace eProduct\MoneyS3\Document\Receipt;

use eProduct\MoneyS3\Document\IDocument;
use XMLWriter;

class Receipt implements IDocument
{
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('Prijemka');
        $writer->text(''); // Force non-self-closing tag
        $writer->endElement();
    }
}