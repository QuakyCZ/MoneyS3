<?php

namespace eProduct\MoneyS3\Agenda;

use eProduct\MoneyS3\Document\Obligation\Obligation;
use XMLWriter;

/**
 * Obligation agenda for managing obligation documents
 */
class ObligationAgenda implements IAgenda
{
    /** @var Obligation[] */
    private array $obligations = [];

    public function getType(): EAgenda
    {
        return EAgenda::RECEIVABLES_AND_PAYABLES;
    }

    public function isEmpty(): bool
    {
        return empty($this->obligations);
    }

    public function flush(): void
    {
        $this->obligations = [];
    }

    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('SeznamZavazku');
        foreach ($this->obligations as $obligation) {
            $obligation->serialize($writer);
        }
        $writer->endElement();
    }

    /**
     * Add new obligation
     *
     * @return Obligation
     */
    public function addObligation(): Obligation
    {
        $obligation = new Obligation();
        $this->obligations[] = $obligation;

        return $obligation;
    }

    /**
     * Get all obligations
     *
     * @return Obligation[]
     */
    public function getObligations(): array
    {
        return $this->obligations;
    }

    /**
     * Get count of obligations
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->obligations);
    }
}
