<?php

namespace eProduct\MoneyS3\Document\Accounting;

use DateTime;
use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Document\IDocument;
use eProduct\MoneyS3\Element;
use XMLWriter;

class AccountingDocument implements IDocument
{
    /** @var Element<bool> */
    private Element $isExpense;

    /** @var Element<string> */
    private Element $documentNumber;

    /** @var Element<string> */
    private Element $registrationNumber;

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
    private Element $issueDate;

    /** @var Element<DateTime> */
    private Element $paymentDate;

    /** @var Element<DateTime> */
    private Element $taxableSupplyDate;

    /** @var Element<DateTime> */
    private Element $vatApplicationDate;

    /** @var Element<int> */
    private Element $statementNumber;

    /** @var Element<string> */
    private Element $statementItemId;

    /** @var Element<string> */
    private Element $counterpartyAccount;

    /** @var Element<string> */
    private Element $counterpartyBankCode;

    /** @var Element<string> */
    private Element $receivedDocument;

    /** @var Element<string> */
    private Element $variableSymbol;

    /** @var Element<string> */
    private Element $pairingSymbol;

    /** @var Element<string> */
    private Element $constantSymbol;

    /** @var Element<string> */
    private Element $specificSymbol;

    /** @var Element<Address> */
    private Element $partner;

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

    /**
     * Constructor for AccountingDocument class
     * 
     * @param AccountingDocumentType $documentType The type of accounting document
     */
    public function __construct(public readonly AccountingDocumentType $documentType)
    {
        $this->isExpense = new Element("Vydej");
        $this->documentNumber = new Element("Doklad", true);
        $this->registrationNumber = new Element("EvCisDokl");
        $this->accountingMethod = new Element("ZpusobUctovani");
        $this->storno = new Element("Storno");
        $this->deleted = new Element("Del");
        $this->description = new Element("Popis");
        $this->accountingDate = new Element("DatUcPr");
        $this->issueDate = new Element("DatVyst");
        $this->paymentDate = new Element("DatPlat");
        $this->taxableSupplyDate = new Element("DatPln");
        $this->vatApplicationDate = new Element("DatUplDPH");
        $this->statementNumber = new Element("Vypis");
        $this->statementItemId = new Element("IDPolozky");
        $this->counterpartyAccount = new Element("AdUcet");
        $this->counterpartyBankCode = new Element("AdKod");
        $this->receivedDocument = new Element("PrijatDokl");
        $this->variableSymbol = new Element("VarSym");
        $this->pairingSymbol = new Element("ParSym");
        $this->constantSymbol = new Element("KonSym");
        $this->specificSymbol = new Element("SpecSym");
        $this->partner = new Element("Adresa");
        $this->preAccount = new Element("PrKont");
        $this->vatSegmentation = new Element("Cleneni");
        $this->center = new Element("Stred");
        $this->project = new Element("Zakazka");
        $this->activity = new Element("Cinnost");
        $this->mossStateCode = new Element("StatMOSS");
        $this->vatCalculationMethod = new Element("ZpVypDPH");
        $this->reducedVatRate = new Element("SSazba");
        $this->standardVatRate = new Element("ZSazba");
        $this->total = new Element("Celkem");
        $this->note = new Element("Pozn");
        $this->numberSeries = new Element("DRada");
        $this->serialNumber = new Element("DCislo");
        $this->issuedBy = new Element("Vyst");
    }

    /**
     * Sets whether this is an expense/issue (true) or income/receipt (false)
     * 
     * @param bool|null $isExpense True for expense/issue, false for income/receipt
     * @return self Returns this instance for method chaining
     */
    public function setIsExpense(?bool $isExpense): self
    {
        $this->isExpense->setValue($isExpense);
        return $this;
    }

    /**
     * Sets the document number
     * 
     * @param string|null $documentNumber The document number in Money S3
     * @return self Returns this instance for method chaining
     */
    public function setDocumentNumber(?string $documentNumber): self
    {
        $this->documentNumber->setValue($documentNumber);
        return $this;
    }

    /**
     * Sets the registration number for tax document
     * 
     * @param string|null $registrationNumber The registration number for VAT control report
     * @return self Returns this instance for method chaining
     */
    public function setRegistrationNumber(?string $registrationNumber): self
    {
        $this->registrationNumber->setValue($registrationNumber);
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
     * Sets the issue date
     * 
     * @param DateTime|null $issueDate The document issue date
     * @return self Returns this instance for method chaining
     */
    public function setIssueDate(?DateTime $issueDate): self
    {
        $this->issueDate->setValue($issueDate);
        return $this;
    }

    /**
     * Sets the payment date
     * 
     * @param DateTime|null $paymentDate The payment date
     * @return self Returns this instance for method chaining
     */
    public function setPaymentDate(?DateTime $paymentDate): self
    {
        $this->paymentDate->setValue($paymentDate);
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
     * Sets the VAT application date
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
     * Sets the bank statement number
     * 
     * @param int|null $statementNumber The bank statement number
     * @return self Returns this instance for method chaining
     */
    public function setStatementNumber(?int $statementNumber): self
    {
        $this->statementNumber->setValue($statementNumber);
        return $this;
    }

    /**
     * Sets the statement item identification
     * 
     * @param string|null $statementItemId The statement item identification
     * @return self Returns this instance for method chaining
     */
    public function setStatementItemId(?string $statementItemId): self
    {
        $this->statementItemId->setValue($statementItemId);
        return $this;
    }

    /**
     * Sets the counterparty account number
     * 
     * @param string|null $counterpartyAccount The counterparty account number
     * @return self Returns this instance for method chaining
     */
    public function setCounterpartyAccount(?string $counterpartyAccount): self
    {
        $this->counterpartyAccount->setValue($counterpartyAccount);
        return $this;
    }

    /**
     * Sets the counterparty bank code
     * 
     * @param string|null $counterpartyBankCode The counterparty bank code
     * @return self Returns this instance for method chaining
     */
    public function setCounterpartyBankCode(?string $counterpartyBankCode): self
    {
        $this->counterpartyBankCode->setValue($counterpartyBankCode);
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
     * Sets the constant symbol
     * 
     * @param string|null $constantSymbol The constant symbol
     * @return self Returns this instance for method chaining
     */
    public function setConstantSymbol(?string $constantSymbol): self
    {
        $this->constantSymbol->setValue($constantSymbol);
        return $this;
    }

    /**
     * Sets the specific symbol
     * 
     * @param string|null $specificSymbol The specific symbol (counterparty account)
     * @return self Returns this instance for method chaining
     */
    public function setSpecificSymbol(?string $specificSymbol): self
    {
        $this->specificSymbol->setValue($specificSymbol);
        return $this;
    }

    /**
     * Sets the document partner
     * 
     * @param Address|null $partner The document partner
     * @return self Returns this instance for method chaining
     */
    public function setPartner(?Address $partner): self
    {
        $this->partner->setValue($partner);
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
     * @param string|null $vatSegmentation The VAT segmentation abbreviation
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
     * Sets the MOSS state code
     * 
     * @param string|null $mossStateCode The MOSS state code (2 characters, only for income bank documents)
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
     * Serializes the accounting document to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $elementName = match ($this->documentType) {
            AccountingDocumentType::BANK_DOCUMENT => 'BanDokl',
            AccountingDocumentType::CASH_DOCUMENT => 'PokDokl',
        };
        
        $writer->startElement($elementName);

        $this->isExpense->serialize($writer);
        $this->documentNumber->serialize($writer);
        $this->registrationNumber->serialize($writer);
        $this->accountingMethod->serialize($writer);
        $this->storno->serialize($writer);
        $this->deleted->serialize($writer);
        $this->description->serialize($writer);
        $this->accountingDate->serialize($writer);
        $this->issueDate->serialize($writer);
        $this->paymentDate->serialize($writer);
        $this->taxableSupplyDate->serialize($writer);
        $this->vatApplicationDate->serialize($writer);
        
        // Bank document specific fields
        if ($this->documentType === AccountingDocumentType::BANK_DOCUMENT) {
            $this->statementNumber->serialize($writer);
            $this->statementItemId->serialize($writer);
            $this->counterpartyAccount->serialize($writer);
            $this->counterpartyBankCode->serialize($writer);
        }
        
        $this->receivedDocument->serialize($writer);
        $this->variableSymbol->serialize($writer);
        $this->pairingSymbol->serialize($writer);
        $this->constantSymbol->serialize($writer);
        $this->specificSymbol->serialize($writer);
        $this->partner->serialize($writer);
        $this->preAccount->serialize($writer);
        $this->vatSegmentation->serialize($writer);
        $this->center->serialize($writer);
        $this->project->serialize($writer);
        $this->activity->serialize($writer);
        $this->mossStateCode->serialize($writer);
        $this->vatCalculationMethod->serialize($writer);
        $this->reducedVatRate->serialize($writer);
        $this->standardVatRate->serialize($writer);
        $this->total->serialize($writer);
        $this->note->serialize($writer);
        $this->numberSeries->serialize($writer);
        $this->serialNumber->serialize($writer);
        $this->issuedBy->serialize($writer);

        $writer->endElement();
    }
}
