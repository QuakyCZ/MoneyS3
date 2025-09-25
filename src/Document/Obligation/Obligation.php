<?php

namespace eProduct\MoneyS3\Document\Obligation;

use DateTime;
use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Document\Common\Partner;
use eProduct\MoneyS3\Document\Common\VatSummary;
use eProduct\MoneyS3\Document\IDocument;
use eProduct\MoneyS3\Element;
use XMLWriter;

/**
 * Obligation class for Money S3 obligation documents (Závazky)
 * Represents supplier invoices and other payable documents
 */
class Obligation implements IDocument
{
    /** @var Element<string> */
    private Element $documentNumber;

    /** @var Element<string> */
    private Element $documentSeries;

    /** @var Element<int> */
    private Element $documentSerialNumber;

    /** @var Element<string> */
    private Element $description;

    /** @var Element<string> */
    private Element $receivedDocument;

    /** @var Element<string> */
    private Element $originalDocumentNumber;

    /** @var Element<string> */
    private Element $variableSymbol;

    /** @var Element<string> */
    private Element $pairingSymbol;

    /** @var Element<string> */
    private Element $constantSymbol;

    /** @var Element<string> */
    private Element $specificSymbol;

    /** @var Element<DateTime> */
    private Element $accountingDate;

    /** @var Element<DateTime> */
    private Element $issued;

    /** @var Element<DateTime> */
    private Element $dueDate;

    /** @var Element<DateTime> */
    private Element $taxableSupplyDate;

    /** @var Element<DateTime> */
    private Element $delivered;

    /** @var Element<bool> */
    private Element $creditNote;

    /** @var Element<DateTime> */
    private Element $creditNoteTaxableSupplyDate;

    /** @var Element<Address> */
    private Element $address;

    /** @var Element<string> */
    private Element $paymentAccount;

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
    private Element $vatFulfillment;

    /** @var Element<string> */
    private Element $vatPurpose;

    /** @var Element<string> */
    private Element $note;

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

    /** @var Element<float> */
    private Element $remainingAmount;

    /** @var Element<DateTime> */
    private Element $paymentDate;

    /** @var Element<string> */
    private Element $paymentDocument;

    /** @var Element<DateTime> */
    private Element $lastPaymentOrderDate;

    /** @var Element<float> */
    private Element $remainingPaymentOrderAmount;

    /** @var Element<float> */
    private Element $foreignCurrencyRemaining;

    /** @var Element<DateTime> */
    private Element $firstReminderDate;

    /** @var Element<DateTime> */
    private Element $secondReminderDate;

    /** @var Element<DateTime> */
    private Element $lastReminderDate;

    /** @var Element<string> */
    private Element $documentType;

    /** @var Element<bool> */
    private Element $simplified;

    /** @var Element<string> */
    private Element $issuer;

    /** @var Element<int> */
    private Element $accountingMethod;

    /** @var Element<int> */
    private Element $storno;

    /** @var Element<bool> */
    private Element $deleted;

    /** @var Element<Partner> */
    private Element $partner;

    public function __construct()
    {
        $this->documentNumber = new Element('Doklad');
        $this->documentSeries = new Element('DRada');
        $this->documentSerialNumber = new Element('DCislo');
        $this->description = new Element('Popis');
        $this->receivedDocument = new Element('PrDokl');
        $this->originalDocumentNumber = new Element('PuvCDokl');
        $this->variableSymbol = new Element('VarSym');
        $this->pairingSymbol = new Element('ParSym');
        $this->constantSymbol = new Element('KonSym');
        $this->specificSymbol = new Element('SpecSym');
        $this->accountingDate = new Element('DatUcPr');
        $this->issued = new Element('DatVyst');
        $this->dueDate = new Element('DatSpl');
        $this->taxableSupplyDate = new Element('DatPln');
        $this->delivered = new Element('Doruceno');
        $this->creditNote = new Element('Dbrpis');
        $this->creditNoteTaxableSupplyDate = new Element('DobrDUZP');
        $this->address = new Element('Adresa');
        $this->paymentAccount = new Element('UcPokl');
        $this->preaccounting = new Element('PrKont');
        $this->vatDivision = new Element('Cleneni');
        $this->costCenter = new Element('Stred');
        $this->project = new Element('Zakazka');
        $this->activity = new Element('Cinnost');
        $this->vatFulfillment = new Element('PlnenDPH');
        $this->vatPurpose = new Element('UcelZdPl');
        $this->note = new Element('Pozn');
        $this->vatCalculationMethod = new Element('ZpVypDPH');
        $this->reducedVatRate = new Element('SSazba');
        $this->standardVatRate = new Element('ZSazba');
        $this->vatSummary = new Element('SouhrnDPH');
        $this->total = new Element('Celkem');
        $this->remainingAmount = new Element('UhZbyva');
        $this->paymentDate = new Element('UhDatum');
        $this->paymentDocument = new Element('UhDokl');
        $this->lastPaymentOrderDate = new Element('PUDatum');
        $this->remainingPaymentOrderAmount = new Element('PUZbyva');
        $this->foreignCurrencyRemaining = new Element('ValutyKUhr');
        $this->firstReminderDate = new Element('DatUpom1');
        $this->secondReminderDate = new Element('DatUpom2');
        $this->lastReminderDate = new Element('DatUpomL');
        $this->documentType = new Element('TypDokl');
        $this->simplified = new Element('ZjednD');
        $this->issuer = new Element('Vyst');
        $this->accountingMethod = new Element('ZpusobUctovani');
        $this->storno = new Element('Storno');
        $this->deleted = new Element('Del');
        $this->partner = new Element('Adresa');
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
     * Set document series
     *
     * @param string|null $documentSeries Document series
     * @return self
     */
    public function setDocumentSeries(?string $documentSeries): self
    {
        $this->documentSeries->setValue($documentSeries);
        return $this;
    }

    /**
     * Set document serial number
     *
     * @param int|null $documentSerialNumber Document serial number
     * @return self
     */
    public function setDocumentSerialNumber(?int $documentSerialNumber): self
    {
        $this->documentSerialNumber->setValue($documentSerialNumber);
        return $this;
    }

    /**
     * Set description
     *
     * @param string|null $description Description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description->setValue($description);
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
     * Set original document number (SK version only)
     *
     * @param string|null $originalDocumentNumber Original document number
     * @return self
     */
    public function setOriginalDocumentNumber(?string $originalDocumentNumber): self
    {
        $this->originalDocumentNumber->setValue($originalDocumentNumber);
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
     * Set constant symbol
     *
     * @param string|null $constantSymbol Constant symbol
     * @return self
     */
    public function setConstantSymbol(?string $constantSymbol): self
    {
        $this->constantSymbol->setValue($constantSymbol);
        return $this;
    }

    /**
     * Set specific symbol
     *
     * @param string|null $specificSymbol Specific symbol
     * @return self
     */
    public function setSpecificSymbol(?string $specificSymbol): self
    {
        $this->specificSymbol->setValue($specificSymbol);
        return $this;
    }

    /**
     * Set accounting date
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
     * Set issued date
     *
     * @param DateTime|null $issued Issued date
     * @return self
     */
    public function setIssued(?DateTime $issued): self
    {
        $this->issued->setValue($issued);
        return $this;
    }

    /**
     * Set due date
     *
     * @param DateTime|null $dueDate Due date
     * @return self
     */
    public function setDueDate(?DateTime $dueDate): self
    {
        $this->dueDate->setValue($dueDate);
        return $this;
    }

    /**
     * Set VAT performed date
     *
     * @param DateTime|null $taxableSupplyDate VAT performed date
     * @return self
     */
    public function setTaxableSupplyDate(?DateTime $taxableSupplyDate): self
    {
        $this->taxableSupplyDate->setValue($taxableSupplyDate);
        return $this;
    }

    /**
     * Set delivered date
     *
     * @param DateTime|null $delivered Delivered date
     * @return self
     */
    public function setDelivered(?DateTime $delivered): self
    {
        $this->delivered->setValue($delivered);
        return $this;
    }

    /**
     * Set credit note flag
     *
     * @param bool|null $creditNote Credit note flag
     * @return self
     */
    public function setCreditNote(?bool $creditNote): self
    {
        $this->creditNote->setValue($creditNote);
        return $this;
    }

    /**
     * Set credit note taxable supply date
     *
     * @param DateTime|null $creditNoteTaxableSupplyDate Credit note taxable supply date
     * @return self
     */
    public function setCreditNoteTaxableSupplyDate(?DateTime $creditNoteTaxableSupplyDate): self
    {
        $this->creditNoteTaxableSupplyDate->setValue($creditNoteTaxableSupplyDate);
        return $this;
    }

    /**
     * Get address
     *
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * Set payment account abbreviation
     *
     * @param string|null $paymentAccount Payment account abbreviation
     * @return self
     */
    public function setPaymentAccount(?string $paymentAccount): self
    {
        $this->paymentAccount->setValue($paymentAccount);
        return $this;
    }

    /**
     * Set preaccounting abbreviation
     *
     * @param string|null $preaccounting Preaccounting abbreviation
     * @return self
     */
    public function setPreaccounting(?string $preaccounting): self
    {
        $this->preaccounting->setValue($preaccounting);
        return $this;
    }

    /**
     * Set VAT division abbreviation
     *
     * @param string|null $vatDivision VAT division abbreviation
     * @return self
     */
    public function setVatDivision(?string $vatDivision): self
    {
        $this->vatDivision->setValue($vatDivision);
        return $this;
    }

    /**
     * Set cost center abbreviation
     *
     * @param string|null $costCenter Cost center abbreviation
     * @return self
     */
    public function setCostCenter(?string $costCenter): self
    {
        $this->costCenter->setValue($costCenter);
        return $this;
    }

    /**
     * Set project abbreviation
     *
     * @param string|null $project Project abbreviation
     * @return self
     */
    public function setProject(?string $project): self
    {
        $this->project->setValue($project);
        return $this;
    }

    /**
     * Set activity abbreviation
     *
     * @param string|null $activity Activity abbreviation
     * @return self
     */
    public function setActivity(?string $activity): self
    {
        $this->activity->setValue($activity);
        return $this;
    }

    /**
     * Set VAT fulfillment mode (SK version only)
     * 0 = by accounting, 1 = by paying full VAT, 2 = by payment
     *
     * @param int|null $vatFulfillment VAT fulfillment mode
     * @return self
     */
    public function setVatFulfillment(?int $vatFulfillment): self
    {
        $this->vatFulfillment->setValue($vatFulfillment);
        return $this;
    }

    /**
     * Set VAT purpose (SK version only)
     *
     * @param string|null $vatPurpose VAT purpose
     * @return self
     */
    public function setVatPurpose(?string $vatPurpose): self
    {
        $this->vatPurpose->setValue($vatPurpose);
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
     * Set VAT calculation method (1 = mathematical, 2 = coefficient)
     *
     * @param int|null $vatCalculationMethod VAT calculation method
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
     * @param float|null $reducedVatRate Reduced VAT rate
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
     * @param float|null $standardVatRate Standard VAT rate
     * @return self
     */
    public function setStandardVatRate(?float $standardVatRate): self
    {
        $this->standardVatRate->setValue($standardVatRate);
        return $this;
    }

    /**
     * Sets the VAT summary for the invoice
     *
     * @param VatSummary|null $vatSummary The VAT summary object
     * @return self Returns this instance for method chaining
     */
    public function setVatSummary(?VatSummary $vatSummary): self
    {
        $this->vatSummary->setValue($vatSummary);
        return $this;
    }

    /**
     * Set total amount
     *
     * @param float|null $total Total amount
     * @return self
     */
    public function setTotal(?float $total): self
    {
        $this->total->setValue($total);
        return $this;
    }

    /**
     * Set remaining amount to pay
     *
     * @param float|null $remainingAmount Remaining amount to pay
     * @return self
     */
    public function setRemainingAmount(?float $remainingAmount): self
    {
        $this->remainingAmount->setValue($remainingAmount);
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
     * Set payment document number
     *
     * @param string|null $paymentDocument Payment document number
     * @return self
     */
    public function setPaymentDocument(?string $paymentDocument): self
    {
        $this->paymentDocument->setValue($paymentDocument);
        return $this;
    }

    /**
     * Set last payment order date
     *
     * @param DateTime|null $lastPaymentOrderDate Last payment order date
     * @return self
     */
    public function setLastPaymentOrderDate(?DateTime $lastPaymentOrderDate): self
    {
        $this->lastPaymentOrderDate->setValue($lastPaymentOrderDate);
        return $this;
    }

    /**
     * Set remaining payment order amount
     *
     * @param float|null $remainingPaymentOrderAmount Remaining payment order amount
     * @return self
     */
    public function setRemainingPaymentOrderAmount(?float $remainingPaymentOrderAmount): self
    {
        $this->remainingPaymentOrderAmount->setValue($remainingPaymentOrderAmount);
        return $this;
    }

    /**
     * Set foreign currency remaining amount
     *
     * @param float|null $foreignCurrencyRemaining Foreign currency remaining amount
     * @return self
     */
    public function setForeignCurrencyRemaining(?float $foreignCurrencyRemaining): self
    {
        $this->foreignCurrencyRemaining->setValue($foreignCurrencyRemaining);
        return $this;
    }

    /**
     * Set first reminder date
     *
     * @param DateTime|null $firstReminderDate First reminder date
     * @return self
     */
    public function setFirstReminderDate(?DateTime $firstReminderDate): self
    {
        $this->firstReminderDate->setValue($firstReminderDate);
        return $this;
    }

    /**
     * Set second reminder date
     *
     * @param DateTime|null $secondReminderDate Second reminder date
     * @return self
     */
    public function setSecondReminderDate(?DateTime $secondReminderDate): self
    {
        $this->secondReminderDate->setValue($secondReminderDate);
        return $this;
    }

    /**
     * Set last reminder date
     *
     * @param DateTime|null $lastReminderDate Last reminder date
     * @return self
     */
    public function setLastReminderDate(?DateTime $lastReminderDate): self
    {
        $this->lastReminderDate->setValue($lastReminderDate);
        return $this;
    }

    /**
     * Set document type abbreviation
     *
     * @param string|null $documentType Document type abbreviation
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
     * Set issuer name
     *
     * @param string|null $issuer Issuer name
     * @return self
     */
    public function setIssuer(?string $issuer): self
    {
        $this->issuer->setValue($issuer);
        return $this;
    }

    /**
     * Set accounting method (0 = default, 1 = don't account)
     *
     * @param int|null $accountingMethod Accounting method
     * @return self
     */
    public function setAccountingMethod(?int $accountingMethod): self
    {
        $this->accountingMethod->setValue($accountingMethod);
        return $this;
    }

    /**
     * Set storno information (0 = normal, 1 = cancelled, 2 = cancelling)
     *
     * @param int|null $storno Storno information
     * @return self
     */
    public function setStorno(?int $storno): self
    {
        $this->storno->setValue($storno);
        return $this;
    }

    /**
     * Set deleted flag
     *
     * @param bool|null $deleted Deleted flag
     * @return self
     */
    public function setDeleted(?bool $deleted): self
    {
        $this->deleted->setValue($deleted);
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

    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement('Zavazek');

        $this->documentNumber->serialize($writer);
        $this->documentSeries->serialize($writer);
        $this->documentSerialNumber->serialize($writer);
        $this->description->serialize($writer);
        $this->receivedDocument->serialize($writer);
        $this->originalDocumentNumber->serialize($writer);
        $this->variableSymbol->serialize($writer);
        $this->pairingSymbol->serialize($writer);
        $this->constantSymbol->serialize($writer);
        $this->specificSymbol->serialize($writer);
        $this->accountingDate->serialize($writer);
        $this->issued->serialize($writer);
        $this->dueDate->serialize($writer);
        $this->taxableSupplyDate->serialize($writer);
        $this->delivered->serialize($writer);
        $this->creditNote->serialize($writer);
        $this->creditNoteTaxableSupplyDate->serialize($writer);
        $this->address->serialize($writer);
        $this->paymentAccount->serialize($writer);
        $this->preaccounting->serialize($writer);
        $this->vatDivision->serialize($writer);
        $this->costCenter->serialize($writer);
        $this->project->serialize($writer);
        $this->activity->serialize($writer);
        $this->vatFulfillment->serialize($writer);
        $this->vatPurpose->serialize($writer);
        $this->note->serialize($writer);
        $this->vatCalculationMethod->serialize($writer);
        $this->reducedVatRate->serialize($writer);
        $this->standardVatRate->serialize($writer);
        $this->vatSummary->serialize($writer);
        $this->total->serialize($writer);
        $this->remainingAmount->serialize($writer);
        $this->paymentDate->serialize($writer);
        $this->paymentDocument->serialize($writer);
        $this->lastPaymentOrderDate->serialize($writer);
        $this->remainingPaymentOrderAmount->serialize($writer);
        $this->foreignCurrencyRemaining->serialize($writer);
        $this->firstReminderDate->serialize($writer);
        $this->secondReminderDate->serialize($writer);
        $this->lastReminderDate->serialize($writer);
        $this->documentType->serialize($writer);
        $this->simplified->serialize($writer);
        $this->issuer->serialize($writer);
        $this->accountingMethod->serialize($writer);
        $this->storno->serialize($writer);
        $this->deleted->serialize($writer);
        $this->partner->serialize($writer);

        $writer->endElement();
    }
}
