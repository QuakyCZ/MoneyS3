<?php

namespace eProduct\MoneyS3\Document\Invoice;

use DateTime;
use eProduct\MoneyS3\Document\Common\Partner;
use eProduct\MoneyS3\Document\Common\VatSummary;
use eProduct\MoneyS3\Document\IDocument;
use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\Enum\EPaymentMethod;
use XMLWriter;

class Invoice implements IDocument
{
    /** @var Element<InvoiceSubtype>  */
    private Element $invoiceSubtype;

    /** @var Element<string> */
    private Element $documentNumber;

    /** @var Element<int> */
    private Element $accountingMethod;

    /** @var Element<int> */
    private Element $numberSeries;

    /** @var Element<string> */
    private Element $description;

    /** @var Element<DateTime> */
    private Element $issued;

    /** @var Element<DateTime> */
    private Element $accountingDate;

    /** @var Element<DateTime> */
    private Element $vatPerformed;

    /** @var Element<DateTime> */
    private Element $dueDate;

    /** @var Element<DateTime> */
    private Element $taxDocumentDate;

    /** @var Element<bool> */
    private Element $simplified;

    /** @var Element<string> */
    private Element $variableSymbol;

    /** @var Element<string> */
    private Element $specificSymbol;

    /** @var Element<string> */
    private Element $constantSymbol;

    /** @var Element<string> */
    private Element $account;

    /** @var Element<string> */
    private Element $type;

    /** @var Element<bool> */
    private Element $creditNote;

    /** @var Element<string> */
    private Element $vatCalculationMethod;

    /** @var Element<int> */
    private Element $vatRate1;

    /** @var Element<int> */
    private Element $vatRate2;

    /** @var Element<float> */
    private Element $toPay;

    /** @var Element<bool> */
    private Element $settled;

    /** @var Element<VatSummary> */
    private Element $vatSummary;

    /** @var Element<float> */
    private Element $total;

    /** @var Element<string> */
    private Element $receivableRemaining;

    /** @var Element<string> */
    private Element $currenciesProperty;

    /** @var Element<string> */
    private Element $depositSum;

    /** @var Element<string> */
    private Element $depositSumTotal;

    /** @var Element<Partner> */
    private Element $partner;

    /** @var Element<FinalRecipient> */
    private Element $finalRecipient;

    /** @var Element<string> */
    private Element $domesticTransport;

    /** @var Element<string> */
    private Element $foreignTransport;

    /** @var Element<string> */
    private Element $discount;

    /** @var Element<InvoiceItem[]> */
    private Element $itemsList;

    /** @var Element<Company> */
    private Element $myCompany;

    /** @var Element<EPaymentMethod> */
    private Element $paymentMethod;

    /**
     * Constructor for Invoice class
     *
     * @param InvoiceType $invoiceType The type of invoice (issued or received)
     */
    public function __construct(
        public readonly InvoiceType $invoiceType,
    )
    {
        $this->invoiceSubtype = new Element('Druh');
        $this->documentNumber = new Element("Doklad");
        $this->accountingMethod = new Element("ZpusobUctovani");
        $this->numberSeries = new Element("CisRada");
        $this->description = new Element("Popis");
        $this->issued = new Element("Vystaveno");
        $this->accountingDate = new Element("DatUcPr");
        $this->vatPerformed = new Element("PlnenoDPH");
        $this->dueDate = new Element("Splatno");
        $this->taxDocumentDate = new Element("DatSkPoh");
        $this->simplified = new Element("ZjednD");
        $this->variableSymbol = new Element("VarSymbol");
        $this->specificSymbol = new Element("SpecSymbol");
        $this->constantSymbol = new Element("KonstSym");
        $this->account = new Element("Ucet");
        $this->type = new Element("Druh");
        $this->creditNote = new Element("Dobropis");
        $this->vatCalculationMethod = new Element("ZpVypDPH");
        $this->vatRate1 = new Element("SazbaDPH1");
        $this->vatRate2 = new Element("SazbaDPH2");
        $this->toPay = new Element("Proplatit");
        $this->settled = new Element("Vyuctovano");
        $this->vatSummary = new Element("SouhrnDPH");
        $this->total = new Element("Celkem");
        $this->receivableRemaining = new Element("PriUhrZbyv");
        $this->currenciesProperty = new Element("ValutyProp");
        $this->depositSum = new Element("SumZaloha");
        $this->depositSumTotal = new Element("SumZalohaC");
        $this->partner = new Element("DodOdb");
        $this->finalRecipient = new Element("KonecPrij");
        $this->domesticTransport = new Element("DopravTuz");
        $this->foreignTransport = new Element("DopravZahr");
        $this->discount = new Element("Sleva");
        $this->itemsList = new Element("SeznamPolozek");
        $this->myCompany = new Element("MojeFirma");
        $this->paymentMethod = new Element("Uhrada");
    }

    /**
     * Sets the document number of the invoice
     *
     * @param string|null $documentNumber The invoice document number
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
     * @param int|null $accountingMethod The accounting method identifier
     * @return self Returns this instance for method chaining
     */
    public function setAccountingMethod(?int $accountingMethod): self
    {
        $this->accountingMethod->setValue($accountingMethod);
        return $this;
    }

    /**
     * Sets the number series for the invoice
     *
     * @param int|null $numberSeries The number series identifier
     * @return self Returns this instance for method chaining
     */
    public function setNumberSeries(?int $numberSeries): self
    {
        $this->numberSeries->setValue($numberSeries);
        return $this;
    }

    /**
     * Sets the description of the invoice
     *
     * @param string|null $description The invoice description
     * @return self Returns this instance for method chaining
     */
    public function setDescription(?string $description): self
    {
        $this->description->setValue($description);
        return $this;
    }

    /**
     * Sets the invoice issue date
     *
     * @param DateTime|null $issued The date when the invoice was issued
     * @return self Returns this instance for method chaining
     */
    public function setIssued(?DateTime $issued): self
    {
        $this->issued->setValue($issued);
        return $this;
    }

    /**
     * Sets the accounting date
     *
     * @param DateTime|null $accountingDate The accounting date for the invoice
     * @return self Returns this instance for method chaining
     */
    public function setAccountingDate(?DateTime $accountingDate): self
    {
        $this->accountingDate->setValue($accountingDate);
        return $this;
    }

    /**
     * Sets when VAT was performed
     *
     * @param string|null $vatPerformed The VAT performance date/period
     * @return self Returns this instance for method chaining
     */
    public function setVatPerformed(?DateTime $vatPerformed): self
    {
        $this->vatPerformed->setValue($vatPerformed);
        return $this;
    }

    /**
     * Sets the due date for payment
     *
     * @param DateTime|null $dueDate The date when payment is due
     * @return self Returns this instance for method chaining
     */
    public function setDueDate(?DateTime $dueDate): self
    {
        $this->dueDate->setValue($dueDate);
        return $this;
    }

    /**
     * Sets the tax document date
     *
     * @param DateTime|null $taxDocumentDate The tax document date
     * @return self Returns this instance for method chaining
     */
    public function setTaxDocumentDate(?DateTime $taxDocumentDate): self
    {
        $this->taxDocumentDate->setValue($taxDocumentDate);
        return $this;
    }

    /**
     * Sets whether this is a simplified invoice
     *
     * @param bool|null $simplified True if simplified, false otherwise
     * @return self Returns this instance for method chaining
     */
    public function setSimplified(?bool $simplified): self
    {
        $this->simplified->setValue($simplified);
        return $this;
    }

    /**
     * Sets the variable symbol for payment identification
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
     * Sets the special symbol for payment identification
     *
     * @param string|null $specificSymbol The special symbol
     * @return self Returns this instance for method chaining
     */
    public function setSpecificSymbol(?string $specificSymbol): self
    {
        $this->specificSymbol->setValue($specificSymbol);
        return $this;
    }

    /**
     * Sets the constant symbol for payment identification
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
     * Sets the bank account for payments
     *
     * @param string|null $account The bank account identifier
     * @return self Returns this instance for method chaining
     */
    public function setAccount(?string $account): self
    {
        $this->account->setValue($account);
        return $this;
    }

    /**
     * Sets the type of the invoice
     *
     * @param string|null $type The invoice type
     * @return self Returns this instance for method chaining
     */
    public function setType(?string $type): self
    {
        $this->type->setValue($type);
        return $this;
    }

    /**
     * Sets whether this is a credit note
     *
     * @param bool|null $creditNote True if credit note, false otherwise
     * @return self Returns this instance for method chaining
     */
    public function setCreditNote(?bool $creditNote): self
    {
        $this->creditNote->setValue($creditNote);
        return $this;
    }

    /**
     * Sets the VAT calculation method
     *
     * @param string|null $vatCalculationMethod The VAT calculation method
     * @return self Returns this instance for method chaining
     */
    public function setVatCalculationMethod(?string $vatCalculationMethod): self
    {
        $this->vatCalculationMethod->setValue($vatCalculationMethod);
        return $this;
    }

    /**
     * Sets the first VAT rate
     *
     * @param int|null $vatRate1 The first VAT rate in percentage
     * @return self Returns this instance for method chaining
     */
    public function setVatRate1(?int $vatRate1): self
    {
        $this->vatRate1->setValue($vatRate1);
        return $this;
    }

    /**
     * Sets the second VAT rate
     *
     * @param int|null $vatRate2 The second VAT rate in percentage
     * @return self Returns this instance for method chaining
     */
    public function setVatRate2(?int $vatRate2): self
    {
        $this->vatRate2->setValue($vatRate2);
        return $this;
    }

    /**
     * Sets the amount to pay
     *
     * @param float|null $toPay The total amount to pay
     * @return self Returns this instance for method chaining
     */
    public function setToPay(?float $toPay): self
    {
        $this->toPay->setValue($toPay);
        return $this;
    }

    /**
     * Sets whether the invoice is settled
     *
     * @param bool|null $settled True if settled, false otherwise
     * @return self Returns this instance for method chaining
     */
    public function setSettled(?bool $settled): self
    {
        $this->settled->setValue($settled);
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
     * Sets the total amount of the invoice
     *
     * @param float|null $total The total invoice amount
     * @return self Returns this instance for method chaining
     */
    public function setTotal(?float $total): self
    {
        $this->total->setValue($total);
        return $this;
    }

    /**
     * Sets the remaining receivable amount
     *
     * @param string|null $receivableRemaining The remaining receivable amount
     * @return self Returns this instance for method chaining
     */
    public function setReceivableRemaining(?string $receivableRemaining): self
    {
        $this->receivableRemaining->setValue($receivableRemaining);
        return $this;
    }

    /**
     * Sets the currencies property
     *
     * @param string|null $currenciesProperty The currencies property
     * @return self Returns this instance for method chaining
     */
    public function setCurrenciesProperty(?string $currenciesProperty): self
    {
        $this->currenciesProperty->setValue($currenciesProperty);
        return $this;
    }

    /**
     * Sets the deposit sum
     *
     * @param string|null $depositSum The deposit sum amount
     * @return self Returns this instance for method chaining
     */
    public function setDepositSum(?string $depositSum): self
    {
        $this->depositSum->setValue($depositSum);
        return $this;
    }

    /**
     * Sets the total deposit sum
     *
     * @param string|null $depositSumTotal The total deposit sum amount
     * @return self Returns this instance for method chaining
     */
    public function setDepositSumTotal(?string $depositSumTotal): self
    {
        $this->depositSumTotal->setValue($depositSumTotal);
        return $this;
    }

    /**
     * Sets the business partner information
     *
     * @param Partner|null $partner The partner object containing business partner details
     * @return self Returns this instance for method chaining
     */
    public function setPartner(?Partner $partner): self
    {
        $this->partner->setValue($partner);
        return $this;
    }

    /**
     * Sets the final recipient information
     *
     * @param FinalRecipient|null $finalRecipient The final recipient object
     * @return self Returns this instance for method chaining
     */
    public function setFinalRecipient(?FinalRecipient $finalRecipient): self
    {
        $this->finalRecipient->setValue($finalRecipient);
        return $this;
    }

    /**
     * Sets the domestic transport costs
     *
     * @param string|null $domesticTransport The domestic transport cost amount
     * @return self Returns this instance for method chaining
     */
    public function setDomesticTransport(?string $domesticTransport): self
    {
        $this->domesticTransport->setValue($domesticTransport);
        return $this;
    }

    /**
     * Sets the foreign transport costs
     *
     * @param string|null $foreignTransport The foreign transport cost amount
     * @return self Returns this instance for method chaining
     */
    public function setForeignTransport(?string $foreignTransport): self
    {
        $this->foreignTransport->setValue($foreignTransport);
        return $this;
    }

    /**
     * Sets the discount amount
     *
     * @param string|null $discount The discount amount
     * @return self Returns this instance for method chaining
     */
    public function setDiscount(?string $discount): self
    {
        $this->discount->setValue($discount);
        return $this;
    }

    /**
     * Sets the list of invoice items
     *
     * @param InvoiceItem[]|null $items Array of invoice items
     * @return self Returns this instance for method chaining
     */
    public function setItemsList(?array $items): self
    {
        $this->itemsList->setValue($items);
        return $this;
    }

    /**
     * Sets the company information for this invoice
     *
     * @param Company|null $company The company object containing business details
     * @return self Returns this instance for method chaining
     */
    public function setMyCompany(?Company $company): self
    {
        $this->myCompany->setValue($company);
        return $this;
    }

    public function setPaymentMethod(?EPaymentMethod $paymentMethod): self
    {
        $this->paymentMethod->setValue($paymentMethod);
        return $this;
    }

    public function setInvoiceSubtype(?InvoiceSubtype $invoiceSubtype): self
    {
        $this->invoiceSubtype->setValue($invoiceSubtype);
        return $this;
    }

    /**
     * Serializes the invoice to XML
     *
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement($this->invoiceType->getRootElement());

        $this->documentNumber->serialize($writer);
        $this->accountingMethod->serialize($writer);
        $this->numberSeries->serialize($writer);
        $this->description->serialize($writer);
        $this->issued->serialize($writer);
        $this->accountingDate->serialize($writer);
        $this->vatPerformed->serialize($writer);
        $this->dueDate->serialize($writer);
        $this->taxDocumentDate->serialize($writer);
        $this->simplified->serialize($writer);
        $this->variableSymbol->serialize($writer);
        $this->account->serialize($writer);
        $this->type->serialize($writer);
        $this->creditNote->serialize($writer);
        $this->vatCalculationMethod->serialize($writer);
        $this->vatRate1->serialize($writer);
        $this->vatRate2->serialize($writer);
        $this->toPay->serialize($writer);
        $this->settled->serialize($writer);
        $this->vatSummary->serialize($writer);
        $this->total->serialize($writer);
        $this->receivableRemaining->serialize($writer);
        $this->currenciesProperty->serialize($writer);
        $this->depositSum->serialize($writer);
        $this->depositSumTotal->serialize($writer);
        $this->partner->serialize($writer);
        $this->finalRecipient->serialize($writer);
        $this->domesticTransport->serialize($writer);
        $this->foreignTransport->serialize($writer);
        $this->discount->serialize($writer);

        // Serialize items list
        if ($this->itemsList->getValue() !== null) {
            $writer->startElement("SeznamPolozek");
            $items = $this->itemsList->getValue();
            foreach ($items as $item) {
                $writer->startElement("Polozka");
                $item->serialize($writer);
                $writer->endElement();
            }
            $writer->endElement();
        }

        $this->myCompany->serialize($writer);
        $this->paymentMethod->serialize($writer);

        $writer->endElement();
    }
}
