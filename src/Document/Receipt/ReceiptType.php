<?php

namespace eProduct\MoneyS3\Document\Receipt;

/**
 * Receipt type enumeration for Money S3 receipts
 * Defines whether the receipt is an expense (Vydej) or income (Prijem)
 */
enum ReceiptType: int
{
    case EXPENSE = 1;  // Vydej = 1
    case INCOME = 0;   // Prijem = 0

    /**
     * Get the XML representation of the receipt type
     */
    public function toXmlValue(): string
    {
        return (string)$this->value;
    }

    /**
     * Get boolean representation (for compatibility)
     */
    public function toBool(): bool
    {
        return $this->value === 1;
    }

    /**
     * Get human-readable name
     */
    public function getName(): string
    {
        return match($this) {
            self::EXPENSE => 'Vydej',
            self::INCOME => 'Prijem',
        };
    }

    /**
     * Create from boolean value
     */
    public static function fromBool(bool $isExpense): self
    {
        return $isExpense ? self::EXPENSE : self::INCOME;
    }
}
