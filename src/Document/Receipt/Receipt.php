<?php

namespace eProduct\MoneyS3\Document\Receipt;

use DateTime;
use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Document\Common\Partner;
use eProduct\MoneyS3\Document\Common\VatSummary;
use eProduct\MoneyS3\Document\IDocument;
use eProduct\MoneyS3\Element;
use XMLWriter;

/**
 * Receipt class for Money S3 receipt documents (Pokladní doklady)
 * Represents cash register receipts for both income and expense transactions
 */
class Receipt implements IDocument
{
    /** @var Element<bool> */
    private Element $expense;

    /** @var Element<string> */
    private Element $documentNumber;

    /** @var Element<string> */
    private Element $evidenceNumber;

    /** @var Element<int> */
    private Element $accountingMethod;

    /** @var Element<string> */
    private Element $description;

    /** @var Element<DateTime> */
    private Element $accountingDate;

    /** @var Element<DateTime> */
    private Element $issued;

    /** @var Element<DateTime> */
    private Element $paymentDate;

    /** @var Element<DateTime> */
    private Element $taxableSupplyDate;

    /** @var Element<DateTime> */
    private Element $vatApplicationDate;

    /** @var Element<string> */
    private Element $receivedDocument;

    /** @var Element<string> */
    private Element $variableSymbol;

    /** @var Element<string> */
    private Element $pairingSymbol;

    /** @var Element<Address> */
    private Element $address;

    /** @var Element<string> */
    private Element $cashRegister;

    /** @var Element<string> */
    private Element $preaccounting;

    /** @var Element<string> */
    private Element $vatDivision;

    /** @var Element<string> */
    private Element $costCenter;

    /** @var Element<string> */
    private Element $project;

    /** @var Element<string> */
    private Element $activity;

    /** @var Element<int> */
    private Element $vatCalculationMethod;

    /** @var Element<float> */
    private Element $reducedVatRate;

    /** @var Element<float> */
    private Element $standardVatRate;

    /** @var Element<VatSummary> */
    private Element $vatSummary;

    /** @var Element<float> */
    private Element $total;

    /** @var Element<string> */
    private Element $note;

    /** @var Element<string> */
    private Element $documentSeries;

    /** @var Element<int> */
    private Element $documentNumber2;

    /** @var Element<string> */
    private Element $issuer;

    /** @var Element<string> */
    private Element $documentType;

    /** @var Element<bool> */
    private Element $simplified;

    /** @var Element<ReceiptItem[]> */
    private Element $itemsList;

    /** @var Element<Address> */
    private Element $myCompany;

    /** @var Element<Partner> */
    private Element $partner;

    /** @var Element <string> */
    private Element $caseShortcut;

    /** @var Element<string> */
    private Element $precoding_abbr;

    public function __construct(
        public readonly ReceiptType $receiptType,
    ) {
        $this->expense = new Element('Vydej');
        $this->documentNumber = new Element('Doklad');
        $this->evidenceNumber = new Element('EvCisDokl');
        $this->accountingMethod = new Element('ZpusobUctovani');
        $this->description = new Element('Popis');
        $this->accountingDate = new Element('DatUcPr');
        $this->issued = new Element('DatVyst');
        $this->paymentDate = new Element('DatPlat');
        $this->taxableSupplyDate = new Element('DatPln');
        $this->vatApplicationDate = new Element('DatUplDPH');
        $this->receivedDocument = new Element('PrijatDokl');
        $this->variableSymbol = new Element('VarSym');
        $this->pairingSymbol = new Element('ParSym');
        $this->address = new Element('Adresa');
        $this->cashRegister = new Element('Pokl');
        $this->preaccounting = new Element('PrKont');
        $this->vatDivision = new Element('Cleneni');
        $this->costCenter = new Element('Stred');
        $this->project = new Element('Zakazka');
        $this->activity = new Element('Cinnost');
        $this->vatCalculationMethod = new Element('ZpVypDPH');
        $this->reducedVatRate = new Element('SSazba');
        $this->standardVatRate = new Element('ZSazba');
        $this->vatSummary = new Element('SouhrnDPH');
        $this->total = new Element('Celkem');
        $this->note = new Element('Pozn');
        $this->documentSeries = new Element('DRada');
        $this->documentNumber2 = new Element('DCislo');
        $this->issuer = new Element('Vyst');
        $this->documentType = new Element('TypDokl');
        $this->simplified = new Element('ZjednD');
        $this->itemsList = new Element('SeznamNormPolozek');
        $this->myCompany = new Element('MojeFirma');
        $this->partner = new Element('Adresa');
        $this->caseShortcut = new Element('Pokl');
        $this->precoding_abbr = new Element('PrKont');

        // Set the receipt type with int value
        $this->expense->setValue($this->receiptType->toBool());
    }

    /**
     * Set document number
     *
     * @param string|null $documentNumber Document number
     * @return self
     */
    public function setDocumentNumber(?string $documentNumber): self
    {
        $this->documentNumber->setValue($documentNumber);
        return $this;
    }

    /**
     * Set evidence number for tax document
     *
     * @param string|null $evidenceNumber Evidence number
     * @return self
     */
    public function setEvidenceNumber(?string $evidenceNumber): self
    {
        $this->evidenceNumber->setValue($evidenceNumber);
        return $this;
    }

    /**
     * Set accounting method
     *
     * @param int|null $accountingMethod Accounting method (0 = default, 1 = no accounting)
     * @return self
     */
    public function setAccountingMethod(?int $accountingMethod): self
    {
        $this->accountingMethod->setValue($accountingMethod);
        return $this;
    }

    /**
     * Set document description
     *
     * @param string|null $description Document description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description->setValue($description);
        return $this;
    }

    /**
     * Set accounting date (only for double-entry accounting)
     *
     * @param DateTime|null $accountingDate Accounting date
     * @return self
     */
    public function setAccountingDate(?DateTime $accountingDate): self
    {
        $this->accountingDate->setValue($accountingDate);
        return $this;
    }

    /**
     * Set issue date
     *
     * @param DateTime|null $issued Issue date
     * @return self
     */
    public function setIssued(?DateTime $issued): self
    {
        $this->issued->setValue($issued);
        return $this;
    }

    /**
     * Set payment date
     *
     * @param DateTime|null $paymentDate Payment date
     * @return self
     */
    public function setPaymentDate(?DateTime $paymentDate): self
    {
        $this->paymentDate->setValue($paymentDate);
        return $this;
    }

    /**
     * Set taxable supply date
     *
     * @param DateTime|null $taxableSupplyDate Taxable supply date
     * @return self
     */
    public function setTaxableSupplyDate(?DateTime $taxableSupplyDate): self
    {
        $this->taxableSupplyDate->setValue($taxableSupplyDate);
        return $this;
    }

    /**
     * Set VAT application date
     *
     * @param DateTime|null $vatApplicationDate VAT application date
     * @return self
     */
    public function setVatApplicationDate(?DateTime $vatApplicationDate): self
    {
        $this->vatApplicationDate->setValue($vatApplicationDate);
        return $this;
    }

    /**
     * Set received document number
     *
     * @param string|null $receivedDocument Received document number
     * @return self
     */
    public function setReceivedDocument(?string $receivedDocument): self
    {
        $this->receivedDocument->setValue($receivedDocument);
        return $this;
    }

    /**
     * Set variable symbol
     *
     * @param string|null $variableSymbol Variable symbol
     * @return self
     */
    public function setVariableSymbol(?string $variableSymbol): self
    {
        $this->variableSymbol->setValue($variableSymbol);
        return $this;
    }

    /**
     * Set pairing symbol
     *
     * @param string|null $pairingSymbol Pairing symbol
     * @return self
     */
    public function setPairingSymbol(?string $pairingSymbol): self
    {
        $this->pairingSymbol->setValue($pairingSymbol);
        return $this;
    }

    /**
     * Set partner address
     *
     * @param Address|null $address Partner address
     * @return self
     */
    public function setAddress(?Address $address): self
    {
        $this->address->setValue($address);
        return $this;
    }

    /**
     * Set cash register code
     *
     * @param string|null $cashRegister Cash register code
     * @return self
     */
    public function setCashRegister(?string $cashRegister): self
    {
        $this->cashRegister->setValue($cashRegister);
        return $this;
    }

    /**
     * Set preaccounting code
     *
     * @param string|null $preaccounting Preaccounting code
     * @return self
     */
    public function setPreaccounting(?string $preaccounting): self
    {
        $this->preaccounting->setValue($preaccounting);
        return $this;
    }

    /**
     * Set VAT division code
     *
     * @param string|null $vatDivision VAT division code
     * @return self
     */
    public function setVatDivision(?string $vatDivision): self
    {
        $this->vatDivision->setValue($vatDivision);
        return $this;
    }

    /**
     * Set cost center
     *
     * @param string|null $costCenter Cost center code
     * @return self
     */
    public function setCostCenter(?string $costCenter): self
    {
        $this->costCenter->setValue($costCenter);
        return $this;
    }

    /**
     * Set project code
     *
     * @param string|null $project Project code
     * @return self
     */
    public function setProject(?string $project): self
    {
        $this->project->setValue($project);
        return $this;
    }

    /**
     * Set activity code
     *
     * @param string|null $activity Activity code
     * @return self
     */
    public function setActivity(?string $activity): self
    {
        $this->activity->setValue($activity);
        return $this;
    }

    /**
     * Set VAT calculation method
     *
     * @param int|null $vatCalculationMethod VAT calculation method (1 = mathematical, 2 = coefficient)
     * @return self
     */
    public function setVatCalculationMethod(?int $vatCalculationMethod): self
    {
        $this->vatCalculationMethod->setValue($vatCalculationMethod);
        return $this;
    }

    /**
     * Set reduced VAT rate
     *
     * @param float|null $reducedVatRate Reduced VAT rate percentage
     * @return self
     */
    public function setReducedVatRate(?float $reducedVatRate): self
    {
        $this->reducedVatRate->setValue($reducedVatRate);
        return $this;
    }

    /**
     * Set standard VAT rate
     *
     * @param float|null $standardVatRate Standard VAT rate percentage
     * @return self
     */
    public function setStandardVatRate(?float $standardVatRate): self
    {
        $this->standardVatRate->setValue($standardVatRate);
        return $this;
    }

    /**
     * Set VAT summary
     *
     * @param VatSummary|null $vatSummary VAT summary
     * @return self
     */
    public function setVatSummary(?VatSummary $vatSummary): self
    {
        $this->vatSummary->setValue($vatSummary);
        return $this;
    }

    /**
     * Set total amount with VAT
     *
     * @param float|null $total Total amount with VAT
     * @return self
     */
    public function setTotal(?float $total): self
    {
        $this->total->setValue($total);
        return $this;
    }

    /**
     * Set note
     *
     * @param string|null $note Note
     * @return self
     */
    public function setNote(?string $note): self
    {
        $this->note->setValue($note);
        return $this;
    }

    /**
     * Set document type
     *
     * @param string|null $documentType Document type code
     * @return self
     */
    public function setDocumentType(?string $documentType): self
    {
        $this->documentType->setValue($documentType);
        return $this;
    }

    /**
     * Set simplified tax document flag
     *
     * @param bool|null $simplified Simplified tax document flag
     * @return self
     */
    public function setSimplified(?bool $simplified): self
    {
        $this->simplified->setValue($simplified);
        return $this;
    }

    /**
     * Add receipt item
     *
     * @param ReceiptItem $item Receipt item
     * @return self
     */
    public function addItem(ReceiptItem $item): self
    {
        $items = $this->itemsList->getValue() ?? [];
        $items[] = $item;
        $this->itemsList->setValue($items);
        return $this;
    }

    /**
     * Sets the list of invoice items
     *
     * @param ReceiptItem[]|null $items Array of ReceiptItem instances
     * @return self Returns this instance for method chaining
     */
    public function setItemsList(?array $items): self
    {
        $this->itemsList->setValue($items);
        return $this;
    }

    /**
     * Set company information
     *
     * @param Address|null $myCompany Company information
     * @return self
     */
    public function setMyCompany(?Address $myCompany): self
    {
        $this->myCompany->setValue($myCompany);
        return $this;
    }

    /**
     * Set partner information
     *
     * @param Partner|null $partner Partner information
     * @return self
     */
    public function setPartner(?Partner $partner): self
    {
        $this->partner->setValue($partner);
        return $this;
    }

    /**
     * Set case shortcut
     *
     * @param string|null $caseShortcut Case shortcut
     * @return self
     */
    public function setCaseShortcut(?string $caseShortcut): self
    {
        $this->caseShortcut->setValue($caseShortcut);
        return $this;
    }

    /**
     * Set preaccounting abbreviation
     *
     * @param string|null $precoding_abbr Preaccounting abbreviation
     * @return self
     */
    public function setPrecodingAbbr(?string $precoding_abbr): self
    {
        $this->precoding_abbr->setValue($precoding_abbr);
        return $this;
    }

    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('PokDokl');

        $this->expense->serialize($writer);
        $this->documentNumber->serialize($writer);
        $this->evidenceNumber->serialize($writer);
        $this->accountingMethod->serialize($writer);
        $this->description->serialize($writer);
        $this->accountingDate->serialize($writer);
        $this->issued->serialize($writer);
        $this->paymentDate->serialize($writer);
        $this->taxableSupplyDate->serialize($writer);
        $this->vatApplicationDate->serialize($writer);
        $this->receivedDocument->serialize($writer);
        $this->variableSymbol->serialize($writer);
        $this->pairingSymbol->serialize($writer);
        $this->address->serialize($writer);
        $this->cashRegister->serialize($writer);
        $this->preaccounting->serialize($writer);
        $this->vatDivision->serialize($writer);
        $this->costCenter->serialize($writer);
        $this->project->serialize($writer);
        $this->activity->serialize($writer);
        $this->vatCalculationMethod->serialize($writer);
        $this->reducedVatRate->serialize($writer);
        $this->standardVatRate->serialize($writer);
        $this->vatSummary->serialize($writer);
        $this->total->serialize($writer);
        $this->note->serialize($writer);
        $this->documentSeries->serialize($writer);
        $this->documentNumber2->serialize($writer);
        $this->issuer->serialize($writer);
        $this->documentType->serialize($writer);
        $this->simplified->serialize($writer);
        $this->partner->serialize($writer);
        $this->caseShortcut->serialize($writer);
        $this->precoding_abbr->serialize($writer);

        // Serialize items list
        if ($this->itemsList->getValue() !== null && count($this->itemsList->getValue()) > 0) {
            $writer->startElement('SeznamNormPolozek');
            foreach ($this->itemsList->getValue() as $item) {
                $item->serialize($writer);
            }
            $writer->endElement();
        }

        $this->myCompany->serialize($writer);
        $writer->endElement();
    }
}
