<?php

namespace eProduct\MoneyS3;

use eProduct\MoneyS3\Exception\MoneyS3Exception;
use XMLWriter;

/**
 * @template T of object
 */
class Element implements ISerializable
{
    /** @var T|null value */
    private mixed $value = null;
    public function __construct(private readonly string $name, private readonly bool $required = false)
    {
    }

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
     * @param T|null $value
     * @return void
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * @return T|null
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}