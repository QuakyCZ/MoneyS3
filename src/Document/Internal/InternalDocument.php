<?php

namespace eProduct\MoneyS3\Document\Internal;

use DateTime;
use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Document\IDocument;
use eProduct\MoneyS3\Element;
use XMLWriter;

class InternalDocument implements IDocument
{
    /** @var Element<string> */
    private Element $documentNumber;

    /** @var Element<int> */
    private Element $accountingMethod;

    /** @var Element<int> */
    private Element $storno;

    /** @var Element<bool> */
    private Element $deleted;

    /** @var Element<string> */
    private Element $description;

    /** @var Element<DateTime> */
    private Element $accountingDate;

    /** @var Element<DateTime> */
    private Element $taxableSupplyDate;

    /** @var Element<DateTime> */
    private Element $vatApplicationDate;

    /** @var Element<DateTime> */
    private Element $kvEntryDate;

    /** @var Element<string> */
    private Element $offsetNumber;

    /** @var Element<string> */
    private Element $receivedDocument;

    /** @var Element<string> */
    private Element $variableSymbol;

    /** @var Element<string> */
    private Element $pairingSymbol;

    /** @var Element<Address> */
    private Element $address;

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

    /** @var Element<float> */
    private Element $production;

    /** @var Element<string> */
    private Element $mossStateCode;

    /** @var Element<int> */
    private Element $vatCalculationMethod;

    /** @var Element<int> */
    private Element $reducedVatRate;

    /** @var Element<int> */
    private Element $standardVatRate;

    /** @var Element<float> */
    private Element $total;

    /** @var Element<string> */
    private Element $note;

    /** @var Element<string> */
    private Element $numberSeries;

    /** @var Element<int> */
    private Element $serialNumber;

    /** @var Element<string> */
    private Element $issuedBy;

    /** @var Element<bool> */
    private Element $regime;

    /** @var Element<bool> */
    private Element $priceCorrection;

    /** @var Element<string> */
    private Element $documentType;

    /** @var Element<InternalDocumentItem[]> */
    private Element $items;

    /**
     * Constructor for InternalDocument class
     */
    public function __construct()
    {
        $this->documentNumber = new Element("Doklad", true);
        $this->accountingMethod = new Element("ZpusobUctovani");
        $this->storno = new Element("Storno");
        $this->deleted = new Element("Del");
        $this->description = new Element("Popis");
        $this->accountingDate = new Element("DatUcPr");
        $this->taxableSupplyDate = new Element("DatPln");
        $this->vatApplicationDate = new Element("DatUplDPH");
        $this->kvEntryDate = new Element("DatumKV");
        $this->offsetNumber = new Element("CisloZapoc");
        $this->receivedDocument = new Element("PrijatDokl");
        $this->variableSymbol = new Element("VarSym");
        $this->pairingSymbol = new Element("ParSym");
        $this->address = new Element("Adresa");
        $this->preAccount = new Element("PrKont");
        $this->vatSegmentation = new Element("Cleneni");
        $this->center = new Element("Stred");
        $this->project = new Element("Zakazka");
        $this->activity = new Element("Cinnost");
        $this->production = new Element("Vyroba");
        $this->mossStateCode = new Element("StatMOSS");
        $this->vatCalculationMethod = new Element("ZpVypDPH");
        $this->reducedVatRate = new Element("SSazba");
        $this->standardVatRate = new Element("ZSazba");
        $this->total = new Element("Celkem");
        $this->note = new Element("Pozn");
        $this->numberSeries = new Element("DRada");
        $this->serialNumber = new Element("DCislo");
        $this->issuedBy = new Element("Vyst");
        $this->regime = new Element("Rezim");
        $this->priceCorrection = new Element("KorekceCen");
        $this->documentType = new Element("TypDokl");
        $this->items = new Element("RozuctPolozka");
    }

    /**
     * Sets the document number
     * 
     * @param string|null $documentNumber The document number
     * @return self Returns this instance for method chaining
     */
    public function setDocumentNumber(?string $documentNumber): self
    {
        $this->documentNumber->setValue($documentNumber);
        return $this;
    }

    /**
     * Sets the accounting method
     * 
     * @param int|null $accountingMethod The accounting method (0=automatic, 1=no accounting)
     * @return self Returns this instance for method chaining
     */
    public function setAccountingMethod(?int $accountingMethod): self
    {
        $this->accountingMethod->setValue($accountingMethod);
        return $this;
    }

    /**
     * Sets the storno information
     * 
     * @param int|null $storno Storno info (0=normal, 1=cancelled, 2=cancelling counter-document)
     * @return self Returns this instance for method chaining
     */
    public function setStorno(?int $storno): self
    {
        $this->storno->setValue($storno);
        return $this;
    }

    /**
     * Sets whether the document is deleted
     * 
     * @param bool|null $deleted True if document is deleted
     * @return self Returns this instance for method chaining
     */
    public function setDeleted(?bool $deleted): self
    {
        $this->deleted->setValue($deleted);
        return $this;
    }

    /**
     * Sets the description
     * 
     * @param string|null $description The document description
     * @return self Returns this instance for method chaining
     */
    public function setDescription(?string $description): self
    {
        $this->description->setValue($description);
        return $this;
    }

    /**
     * Sets the accounting date
     * 
     * @param DateTime|null $accountingDate The accounting transaction date
     * @return self Returns this instance for method chaining
     */
    public function setAccountingDate(?DateTime $accountingDate): self
    {
        $this->accountingDate->setValue($accountingDate);
        return $this;
    }

    /**
     * Sets the taxable supply date
     * 
     * @param DateTime|null $taxableSupplyDate The taxable supply date
     * @return self Returns this instance for method chaining
     */
    public function setTaxableSupplyDate(?DateTime $taxableSupplyDate): self
    {
        $this->taxableSupplyDate->setValue($taxableSupplyDate);
        return $this;
    }

    /**
     * Sets the VAT application date (CZ version only)
     * 
     * @param DateTime|null $vatApplicationDate The VAT application date
     * @return self Returns this instance for method chaining
     */
    public function setVatApplicationDate(?DateTime $vatApplicationDate): self
    {
        $this->vatApplicationDate->setValue($vatApplicationDate);
        return $this;
    }

    /**
     * Sets the KV entry date (SK version only)
     * 
     * @param DateTime|null $kvEntryDate The KV entry date
     * @return self Returns this instance for method chaining
     */
    public function setKvEntryDate(?DateTime $kvEntryDate): self
    {
        $this->kvEntryDate->setValue($kvEntryDate);
        return $this;
    }

    /**
     * Sets the mutual offset number
     * 
     * @param string|null $offsetNumber The mutual offset number
     * @return self Returns this instance for method chaining
     */
    public function setOffsetNumber(?string $offsetNumber): self
    {
        $this->offsetNumber->setValue($offsetNumber);
        return $this;
    }

    /**
     * Sets the received document number
     * 
     * @param string|null $receivedDocument The received document number
     * @return self Returns this instance for method chaining
     */
    public function setReceivedDocument(?string $receivedDocument): self
    {
        $this->receivedDocument->setValue($receivedDocument);
        return $this;
    }

    /**
     * Sets the variable symbol
     * 
     * @param string|null $variableSymbol The variable symbol
     * @return self Returns this instance for method chaining
     */
    public function setVariableSymbol(?string $variableSymbol): self
    {
        $this->variableSymbol->setValue($variableSymbol);
        return $this;
    }

    /**
     * Sets the pairing symbol
     * 
     * @param string|null $pairingSymbol The pairing symbol
     * @return self Returns this instance for method chaining
     */
    public function setPairingSymbol(?string $pairingSymbol): self
    {
        $this->pairingSymbol->setValue($pairingSymbol);
        return $this;
    }

    /**
     * Sets the document addressee
     * 
     * @param Address|null $address The document addressee
     * @return self Returns this instance for method chaining
     */
    public function setAddress(?Address $address): self
    {
        $this->address->setValue($address);
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
     * Sets the production amount (for Production module needs)
     * 
     * @param float|null $production The production amount
     * @return self Returns this instance for method chaining
     */
    public function setProduction(?float $production): self
    {
        $this->production->setValue($production);
        return $this;
    }

    /**
     * Sets the MOSS state code
     * 
     * @param string|null $mossStateCode The MOSS state code (2 characters)
     * @return self Returns this instance for method chaining
     */
    public function setMossStateCode(?string $mossStateCode): self
    {
        $this->mossStateCode->setValue($mossStateCode);
        return $this;
    }

    /**
     * Sets the VAT calculation method
     * 
     * @param int|null $vatCalculationMethod The VAT calculation method (1=mathematical, 2=coefficient)
     * @return self Returns this instance for method chaining
     */
    public function setVatCalculationMethod(?int $vatCalculationMethod): self
    {
        $this->vatCalculationMethod->setValue($vatCalculationMethod);
        return $this;
    }

    /**
     * Sets the reduced VAT rate
     * 
     * @param int|null $reducedVatRate The reduced VAT rate in percentage
     * @return self Returns this instance for method chaining
     */
    public function setReducedVatRate(?int $reducedVatRate): self
    {
        $this->reducedVatRate->setValue($reducedVatRate);
        return $this;
    }

    /**
     * Sets the standard VAT rate
     * 
     * @param int|null $standardVatRate The standard VAT rate in percentage
     * @return self Returns this instance for method chaining
     */
    public function setStandardVatRate(?int $standardVatRate): self
    {
        $this->standardVatRate->setValue($standardVatRate);
        return $this;
    }

    /**
     * Sets the total amount
     * 
     * @param float|null $total The total amount with VAT
     * @return self Returns this instance for method chaining
     */
    public function setTotal(?float $total): self
    {
        $this->total->setValue($total);
        return $this;
    }

    /**
     * Sets a note
     * 
     * @param string|null $note The document note
     * @return self Returns this instance for method chaining
     */
    public function setNote(?string $note): self
    {
        $this->note->setValue($note);
        return $this;
    }

    /**
     * Sets the number series prefix
     * 
     * @param string|null $numberSeries The number series prefix
     * @return self Returns this instance for method chaining
     */
    public function setNumberSeries(?string $numberSeries): self
    {
        $this->numberSeries->setValue($numberSeries);
        return $this;
    }

    /**
     * Sets the serial number counter
     * 
     * @param int|null $serialNumber The number series counter
     * @return self Returns this instance for method chaining
     */
    public function setSerialNumber(?int $serialNumber): self
    {
        $this->serialNumber->setValue($serialNumber);
        return $this;
    }

    /**
     * Sets who issued the document
     * 
     * @param string|null $issuedBy The user who issued the document
     * @return self Returns this instance for method chaining
     */
    public function setIssuedBy(?string $issuedBy): self
    {
        $this->issuedBy->setValue($issuedBy);
        return $this;
    }

    /**
     * Sets the regime
     * 
     * @param bool|null $regime The regime setting
     * @return self Returns this instance for method chaining
     */
    public function setRegime(?bool $regime): self
    {
        $this->regime->setValue($regime);
        return $this;
    }

    /**
     * Sets price correction
     * 
     * @param bool|null $priceCorrection The price correction setting
     * @return self Returns this instance for method chaining
     */
    public function setPriceCorrection(?bool $priceCorrection): self
    {
        $this->priceCorrection->setValue($priceCorrection);
        return $this;
    }

    /**
     * Sets the document type
     * 
     * @param string|null $documentType The document type abbreviation
     * @return self Returns this instance for method chaining
     */
    public function setDocumentType(?string $documentType): self
    {
        $this->documentType->setValue($documentType);
        return $this;
    }

    /**
     * Sets the list of document items
     * 
     * @param InternalDocumentItem[]|null $items Array of document items
     * @return self Returns this instance for method chaining
     */
    public function setItems(?array $items): self
    {
        $this->items->setValue($items);
        return $this;
    }

    /**
     * Serializes the internal document to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement("IntDokl");

        $this->documentNumber->serialize($writer);
        $this->accountingMethod->serialize($writer);
        $this->storno->serialize($writer);
        $this->deleted->serialize($writer);
        $this->description->serialize($writer);
        $this->accountingDate->serialize($writer);
        $this->taxableSupplyDate->serialize($writer);
        $this->vatApplicationDate->serialize($writer);
        $this->kvEntryDate->serialize($writer);
        $this->offsetNumber->serialize($writer);
        $this->receivedDocument->serialize($writer);
        $this->variableSymbol->serialize($writer);
        $this->pairingSymbol->serialize($writer);
        $this->address->serialize($writer);
        $this->preAccount->serialize($writer);
        $this->vatSegmentation->serialize($writer);
        $this->center->serialize($writer);
        $this->project->serialize($writer);
        $this->activity->serialize($writer);
        $this->production->serialize($writer);
        $this->mossStateCode->serialize($writer);
        $this->vatCalculationMethod->serialize($writer);
        $this->reducedVatRate->serialize($writer);
        $this->standardVatRate->serialize($writer);
        $this->total->serialize($writer);
        $this->note->serialize($writer);
        $this->numberSeries->serialize($writer);
        $this->serialNumber->serialize($writer);
        $this->issuedBy->serialize($writer);
        $this->regime->serialize($writer);
        $this->priceCorrection->serialize($writer);
        $this->documentType->serialize($writer);

        // Serialize items list
        if ($this->items->getValue() !== null) {
            $items = $this->items->getValue();
            foreach ($items as $item) {
                $writer->startElement("RozuctPolozka");
                $item->serialize($writer);
                $writer->endElement();
            }
        }

        $writer->endElement();
    }
}
