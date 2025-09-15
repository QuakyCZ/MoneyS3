<?php

declare (strict_types=1);

namespace eProduct\MoneyS3\Agenda;

use eProduct\MoneyS3\Document\Receipt\Receipt;
use eProduct\MoneyS3\Document\Receipt\ReceiptType;
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

    /**
     * Add a new receipt with specified type
     *
     * @param ReceiptType $receiptType Receipt type (EXPENSE or INCOME)
     * @return Receipt
     */
    public function addReceipt(ReceiptType $receiptType): Receipt
    {
        $receipt = new Receipt($receiptType);
        $this->receipts[] = $receipt;
        return $receipt;
    }

    /**
     * Add a pre-created receipt
     *
     * @param Receipt $receipt Pre-created receipt
     * @return self
     */
    public function addReceiptRaw(Receipt $receipt): self
    {
        $this->receipts[] = $receipt;
        return $this;
    }

    /**
     * Get all receipts
     *
     * @return Receipt[]
     */
    public function getReceipts(): array
    {
        return $this->receipts;
    }
}
