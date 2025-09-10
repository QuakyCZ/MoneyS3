<?php

namespace eProduct\MoneyS3\Document\Internal;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\ISerializable;
use XMLWriter;

class InternalDocumentItem implements ISerializable
{
    /** @var Element<string> */
    private Element $description;

    /** @var Element<string> */
    private Element $debitAccount;

    /** @var Element<string> */
    private Element $creditAccount;

    /** @var Element<float> */
    private Element $amount;

    /** @var Element<string> */
    private Element $preAccount;

    /** @var Element<string> */
    private Element $vatSegmentation;

    /** @var Element<string> */
    private Element $center;

    /** @var Element<string> */
    private Element $project;

    /** @var Element<string> */
    private Element $activity;

    /** @var Element<string> */
    private Element $note;

    /**
     * Constructor for InternalDocumentItem class
     */
    public function __construct()
    {
        $this->description = new Element("Popis");
        $this->debitAccount = new Element("UcMD");
        $this->creditAccount = new Element("UcD");
        $this->amount = new Element("Castka");
        $this->preAccount = new Element("PrKont");
        $this->vatSegmentation = new Element("Cleneni");
        $this->center = new Element("Stred");
        $this->project = new Element("Zakazka");
        $this->activity = new Element("Cinnost");
        $this->note = new Element("Poznamka");
    }

    /**
     * Sets the item description
     *
     * @param string|null $description The item description
     * @return self Returns this instance for method chaining
     */
    public function setDescription(?string $description): self
    {
        $this->description->setValue($description);
        return $this;
    }

    /**
     * Sets the debit account
     *
     * @param string|null $debitAccount The debit account (MD)
     * @return self Returns this instance for method chaining
     */
    public function setDebitAccount(?string $debitAccount): self
    {
        $this->debitAccount->setValue($debitAccount);
        return $this;
    }

    /**
     * Sets the credit account
     *
     * @param string|null $creditAccount The credit account (Dal)
     * @return self Returns this instance for method chaining
     */
    public function setCreditAccount(?string $creditAccount): self
    {
        $this->creditAccount->setValue($creditAccount);
        return $this;
    }

    /**
     * Sets the item amount
     *
     * @param float|null $amount The item amount
     * @return self Returns this instance for method chaining
     */
    public function setAmount(?float $amount): self
    {
        $this->amount->setValue($amount);
        return $this;
    }

    /**
     * Sets the pre-account
     *
     * @param string|null $preAccount The pre-account abbreviation
     * @return self Returns this instance for method chaining
     */
    public function setPreAccount(?string $preAccount): self
    {
        $this->preAccount->setValue($preAccount);
        return $this;
    }

    /**
     * Sets the VAT segmentation
     *
     * @param string|null $vatSegmentation The VAT segmentation
     * @return self Returns this instance for method chaining
     */
    public function setVatSegmentation(?string $vatSegmentation): self
    {
        $this->vatSegmentation->setValue($vatSegmentation);
        return $this;
    }

    /**
     * Sets the center
     *
     * @param string|null $center The center abbreviation
     * @return self Returns this instance for method chaining
     */
    public function setCenter(?string $center): self
    {
        $this->center->setValue($center);
        return $this;
    }

    /**
     * Sets the project
     *
     * @param string|null $project The project abbreviation
     * @return self Returns this instance for method chaining
     */
    public function setProject(?string $project): self
    {
        $this->project->setValue($project);
        return $this;
    }

    /**
     * Sets the activity
     *
     * @param string|null $activity The activity abbreviation
     * @return self Returns this instance for method chaining
     */
    public function setActivity(?string $activity): self
    {
        $this->activity->setValue($activity);
        return $this;
    }

    /**
     * Sets a note for the item
     *
     * @param string|null $note The item note
     * @return self Returns this instance for method chaining
     */
    public function setNote(?string $note): self
    {
        $this->note->setValue($note);
        return $this;
    }

    /**
     * Serializes the internal document item to XML
     *
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $this->description->serialize($writer);
        $this->debitAccount->serialize($writer);
        $this->creditAccount->serialize($writer);
        $this->amount->serialize($writer);
        $this->preAccount->serialize($writer);
        $this->vatSegmentation->serialize($writer);
        $this->center->serialize($writer);
        $this->project->serialize($writer);
        $this->activity->serialize($writer);
        $this->note->serialize($writer);
    }
}
