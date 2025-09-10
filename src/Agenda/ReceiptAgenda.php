<?php

declare (strict_types=1);

namespace eProduct\MoneyS3\Agenda;

use eProduct\MoneyS3\Document\Receipt\Receipt;
use XMLWriter;

class ReceiptAgenda implements IAgenda
{
    /** @var Receipt[] */
    private array $receipts = [];


    public function getType(): EAgenda
    {
        return EAgenda::RECEIPTS;
    }

    public function isEmpty(): bool
    {
        return empty($this->receipts);
    }

    public function flush(): void
    {
        $this->receipts = [];
    }

    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('SeznamPokDokl');
        foreach ($this->receipts as $receipt) {
            $receipt->serialize($writer);
        }
        $writer->endElement();
    }

    public function addReceipt(): Receipt
    {
        $receipt = new Receipt();
        $this->receipts[] = $receipt;
        return $receipt;
    }

    public function addReceiptRaw(Receipt $receipt): self
    {
        $this->receipts[] = $receipt;
        return $this;
    }
}
