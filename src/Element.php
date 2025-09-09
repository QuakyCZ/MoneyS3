<?php

namespace eProduct\MoneyS3;

use eProduct\MoneyS3\Exception\MoneyS3Exception;
use XMLWriter;

/**
 * @template T
 */
class Element implements ISerializable
{
    /** @var T|null value */
    private mixed $value = null;
    
    /**
     * Constructor for Element class
     * 
     * @param string $name The XML element name
     * @param bool $required Whether this element is required in XML output
     */
    public function __construct(private readonly string $name, private readonly bool $required = false)
    {
    }

    /**
     * Serializes this element to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @throws MoneyS3Exception When required element is not set
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        if ($this->value === null) {
            if ($this->required) {
                throw new MoneyS3Exception("Element {$this->name} is required but not set.");
            }
            return;
        }

        if ($this->value instanceof ISerializable) {
            $writer->startElement($this->name);
            $this->value->serialize($writer);
            $writer->endElement();
        } else {
            $writer->writeElement($this->name, $this->serializeValue());
        }
    }

    /**
     * Converts the value to a string representation for XML serialization
     * 
     * @return string|null String representation of the value or null if value is null
     */
    private function serializeValue(): ?string
    {
        if ($this->value === null) {
            return null;
        }

        if (is_bool($this->value)) {
            return $this->value ? '1' : '0';
        }

        if ($this->value instanceof \DateTime) {
            return $this->value->format('Y-m-d');
        }

        return (string)$this->value;
    }

    /**
     * Sets the value of this element
     * 
     * @param T|null $value The value to set
     * @return void
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * Gets the value of this element
     * 
     * @return T|null The current value or null if not set
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}