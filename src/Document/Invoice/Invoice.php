<?php

namespace eProduct\MoneyS3\Document\Invoice;

use DateTime;
use eProduct\MoneyS3\Document\IDocument;
use eProduct\MoneyS3\Element;
use XMLWriter;

class Invoice implements IDocument
{
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

    /** @var Element<string> */
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

    public function __construct(public readonly InvoiceType $invoiceType)
    {
        $this->documentNumber = new Element("Doklad", true);
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
        $this->myCompany = new Element("MojeFirma", true);
    }

    public function setDocumentNumber(string $documentNumber): self
    {
        $this->documentNumber->setValue($documentNumber);
        return $this;
    }

    public function setAccountingMethod(int $accountingMethod): self
    {
        $this->accountingMethod->setValue($accountingMethod);
        return $this;
    }

    public function setNumberSeries(int $numberSeries): self
    {
        $this->numberSeries->setValue($numberSeries);
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description->setValue($description);
        return $this;
    }

    public function setIssued(DateTime $issued): self
    {
        $this->issued->setValue($issued);
        return $this;
    }

    public function setAccountingDate(DateTime $accountingDate): self
    {
        $this->accountingDate->setValue($accountingDate);
        return $this;
    }

    public function setVatPerformed(string $vatPerformed): self
    {
        $this->vatPerformed->setValue($vatPerformed);
        return $this;
    }

    public function setDueDate(DateTime $dueDate): self
    {
        $this->dueDate->setValue($dueDate);
        return $this;
    }

    public function setTaxDocumentDate(DateTime $taxDocumentDate): self
    {
        $this->taxDocumentDate->setValue($taxDocumentDate);
        return $this;
    }

    public function setSimplified(bool $simplified): self
    {
        $this->simplified->setValue($simplified);
        return $this;
    }

    public function setVariableSymbol(string $variableSymbol): self
    {
        $this->variableSymbol->setValue($variableSymbol);
        return $this;
    }

    public function setAccount(string $account): self
    {
        $this->account->setValue($account);
        return $this;
    }

    public function setType(string $type): self
    {
        $this->type->setValue($type);
        return $this;
    }

    public function setCreditNote(bool $creditNote): self
    {
        $this->creditNote->setValue($creditNote);
        return $this;
    }

    public function setVatCalculationMethod(string $vatCalculationMethod): self
    {
        $this->vatCalculationMethod->setValue($vatCalculationMethod);
        return $this;
    }

    public function setVatRate1(int $vatRate1): self
    {
        $this->vatRate1->setValue($vatRate1);
        return $this;
    }

    public function setVatRate2(int $vatRate2): self
    {
        $this->vatRate2->setValue($vatRate2);
        return $this;
    }

    public function setToPay(float $toPay): self
    {
        $this->toPay->setValue($toPay);
        return $this;
    }

    public function setSettled(bool $settled): self
    {
        $this->settled->setValue($settled);
        return $this;
    }

    public function setVatSummary(VatSummary $vatSummary): self
    {
        $this->vatSummary->setValue($vatSummary);
        return $this;
    }

    public function setTotal(float $total): self
    {
        $this->total->setValue($total);
        return $this;
    }

    public function setReceivableRemaining(string $receivableRemaining): self
    {
        $this->receivableRemaining->setValue($receivableRemaining);
        return $this;
    }

    public function setCurrenciesProperty(string $currenciesProperty): self
    {
        $this->currenciesProperty->setValue($currenciesProperty);
        return $this;
    }

    public function setDepositSum(string $depositSum): self
    {
        $this->depositSum->setValue($depositSum);
        return $this;
    }

    public function setDepositSumTotal(string $depositSumTotal): self
    {
        $this->depositSumTotal->setValue($depositSumTotal);
        return $this;
    }

    public function setPartner(Partner $partner): self
    {
        $this->partner->setValue($partner);
        return $this;
    }

    public function setFinalRecipient(FinalRecipient $finalRecipient): self
    {
        $this->finalRecipient->setValue($finalRecipient);
        return $this;
    }

    public function setDomesticTransport(string $domesticTransport): self
    {
        $this->domesticTransport->setValue($domesticTransport);
        return $this;
    }

    public function setForeignTransport(string $foreignTransport): self
    {
        $this->foreignTransport->setValue($foreignTransport);
        return $this;
    }

    public function setDiscount(string $discount): self
    {
        $this->discount->setValue($discount);
        return $this;
    }

    /**
     * @param InvoiceItem[] $items
     */
    public function setItemsList(array $items): self
    {
        $this->itemsList->setValue($items);
        return $this;
    }

    public function setMyCompany(Company $company): self
    {
        $this->myCompany->setValue($company);
        return $this;
    }

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

        $writer->endElement();
    }
}