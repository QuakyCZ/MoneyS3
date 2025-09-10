<?php

namespace eProduct\MoneyS3\Document\Receipt;

use eProduct\MoneyS3\Document\IDocument;
use eProduct\MoneyS3\Element;
use XMLWriter;

readonly class Receipt implements IDocument
{
    /** @var Element<?string> */
    private Element $documentNumber;


    public function __construct()
    {
        $this->documentNumber = new Element('Doklad');
    }

    /**
     * Serializes the receipt to XML
     *
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('PokDokl');
        $this->documentNumber->serialize($writer);
        $writer->endElement();
    }

    public function setDocumentNumber(?string $string): void
    {
        $this->documentNumber->setValue($string);
    }
}
