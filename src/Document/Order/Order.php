<?php

namespace eProduct\MoneyS3\Document\Order;

use DateTime;
use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Document\IDocument;
use eProduct\MoneyS3\Element;
use XMLWriter;

class Order implements IDocument
{
    /** @var Element<string> */
    private Element $documentNumber;

    /** @var Element<string> */
    private Element $description;

    /** @var Element<string> */
    private Element $note;

    /** @var Element<string> */
    private Element $textBeforeItems;

    /** @var Element<string> */
    private Element $textAfterItems;

    /** @var Element<DateTime> */
    private Element $issued;

    /** @var Element<DateTime> */
    private Element $dueDate;

    /** @var Element<DateTime> */
    private Element $completed;

    /** @var Element<string> */
    private Element $partner;

    /** @var Element<Address> */
    private Element $finalRecipient;

    /** @var Element<bool> */
    private Element $finalRecipientFromPartner;

    /** @var Element<float> */
    private Element $total;

    /** @var Element<string> */
    private Element $numberSeries;

    /** @var Element<int> */
    private Element $documentSerialNumber;

    /** @var Element<string> */
    private Element $center;

    /** @var Element<string> */
    private Element $project;

    /** @var Element<string> */
    private Element $activity;

    /** @var Element<string> */
    private Element $issuedBy;

    /** @var Element<bool> */
    private Element $doNotReserve;

    /** @var Element<bool> */
    private Element $fixedPrices;

    /** @var Element<string> */
    private Element $paymentTerms;

    /** @var Element<string> */
    private Element $shipping;

    /** @var Element<string> */
    private Element $title;

    /** @var Element<DateTime> */
    private Element $latestDueDate;

    /** @var Element<string> */
    private Element $typeAbbreviation;

    /** @var Element<string> */
    private Element $primaryDocument;

    /** @var Element<string> */
    private Element $variableSymbol;

    /** @var Element<bool> */
    private Element $doNotProcess;

    /** @var Element<int> */
    private Element $vatCalculationMethod;

    /** @var Element<int> */
    private Element $vatRate1;

    /** @var Element<int> */
    private Element $vatRate2;

    /** @var Element<float> */
    private Element $discount;

    /** @var Element<OrderItem[]> */
    private Element $itemsList;

    /** @var Element<string> */
    private Element $myCompany;

    /**
     * Constructor for Order class
     * 
     * @param OrderType $orderType The type of order (received, issued, offer, inquiry)
     */
    public function __construct(public readonly OrderType $orderType)
    {
        $this->documentNumber = new Element("Doklad", true);
        $this->description = new Element("Popis");
        $this->note = new Element("Poznamka");
        $this->textBeforeItems = new Element("TextPredPo");
        $this->textAfterItems = new Element("TextZaPol");
        $this->issued = new Element("Vystaveno");
        $this->dueDate = new Element("Vyridit_do");
        $this->completed = new Element("Vyrizeno");
        $this->partner = new Element("DodOdb");
        $this->finalRecipient = new Element("KonecPrij");
        $this->finalRecipientFromPartner = new Element("KPFromOdb");
        $this->total = new Element("Celkem");
        $this->numberSeries = new Element("DRada");
        $this->documentSerialNumber = new Element("DCislo");
        $this->center = new Element("Stredisko");
        $this->project = new Element("Zakazka");
        $this->activity = new Element("Cinnost");
        $this->issuedBy = new Element("Vystavil");
        $this->doNotReserve = new Element("NeRezervov");
        $this->fixedPrices = new Element("PevneCeny");
        $this->paymentTerms = new Element("PlatPodm");
        $this->shipping = new Element("Doprava");
        $this->title = new Element("Nadpis");
        $this->latestDueDate = new Element("VyriditNej");
        $this->typeAbbreviation = new Element("ZkratkaTyp");
        $this->primaryDocument = new Element("PrimDoklad");
        $this->variableSymbol = new Element("VarSymbol");
        $this->doNotProcess = new Element("NeVyrizova");
        $this->vatCalculationMethod = new Element("ZpVypDPH");
        $this->vatRate1 = new Element("SazbaDPH1");
        $this->vatRate2 = new Element("SazbaDPH2");
        $this->discount = new Element("Sleva");
        $this->itemsList = new Element("Polozka");
        $this->myCompany = new Element("MojeFirma");
    }

    /**
     * Sets the document number of the order
     * 
     * @param string|null $documentNumber The order document number
     * @return self Returns this instance for method chaining
     */
    public function setDocumentNumber(?string $documentNumber): self
    {
        $this->documentNumber->setValue($documentNumber);
        return $this;
    }

    /**
     * Sets the description of the order
     * 
     * @param string|null $description The order description
     * @return self Returns this instance for method chaining
     */
    public function setDescription(?string $description): self
    {
        $this->description->setValue($description);
        return $this;
    }

    /**
     * Sets a note for the order
     * 
     * @param string|null $note The order note
     * @return self Returns this instance for method chaining
     */
    public function setNote(?string $note): self
    {
        $this->note->setValue($note);
        return $this;
    }

    /**
     * Sets text to appear before items
     * 
     * @param string|null $textBeforeItems Text before items list
     * @return self Returns this instance for method chaining
     */
    public function setTextBeforeItems(?string $textBeforeItems): self
    {
        $this->textBeforeItems->setValue($textBeforeItems);
        return $this;
    }

    /**
     * Sets text to appear after items
     * 
     * @param string|null $textAfterItems Text after items list
     * @return self Returns this instance for method chaining
     */
    public function setTextAfterItems(?string $textAfterItems): self
    {
        $this->textAfterItems->setValue($textAfterItems);
        return $this;
    }

    /**
     * Sets the order issue date
     * 
     * @param DateTime|null $issued The date when the order was issued
     * @return self Returns this instance for method chaining
     */
    public function setIssued(?DateTime $issued): self
    {
        $this->issued->setValue($issued);
        return $this;
    }

    /**
     * Sets the due date for completion
     * 
     * @param DateTime|null $dueDate The date when order should be completed
     * @return self Returns this instance for method chaining
     */
    public function setDueDate(?DateTime $dueDate): self
    {
        $this->dueDate->setValue($dueDate);
        return $this;
    }

    /**
     * Sets the completion date
     * 
     * @param DateTime|null $completed The date when order was completed
     * @return self Returns this instance for method chaining
     */
    public function setCompleted(?DateTime $completed): self
    {
        $this->completed->setValue($completed);
        return $this;
    }

    /**
     * Sets the business partner information
     * 
     * @param string|null $partner The partner reference
     * @return self Returns this instance for method chaining
     */
    public function setPartner(?string $partner): self
    {
        $this->partner->setValue($partner);
        return $this;
    }

    /**
     * Sets the final recipient information
     * 
     * @param Address|null $finalRecipient The final recipient address
     * @return self Returns this instance for method chaining
     */
    public function setFinalRecipient(?Address $finalRecipient): self
    {
        $this->finalRecipient->setValue($finalRecipient);
        return $this;
    }

    /**
     * Sets whether final recipient should be taken from partner
     * 
     * @param bool|null $finalRecipientFromPartner True to use partner address
     * @return self Returns this instance for method chaining
     */
    public function setFinalRecipientFromPartner(?bool $finalRecipientFromPartner): self
    {
        $this->finalRecipientFromPartner->setValue($finalRecipientFromPartner);
        return $this;
    }

    /**
     * Sets the total amount of the order
     * 
     * @param float|null $total The total order amount
     * @return self Returns this instance for method chaining
     */
    public function setTotal(?float $total): self
    {
        $this->total->setValue($total);
        return $this;
    }

    /**
     * Sets the number series for the order
     * 
     * @param string|null $numberSeries The number series abbreviation
     * @return self Returns this instance for method chaining
     */
    public function setNumberSeries(?string $numberSeries): self
    {
        $this->numberSeries->setValue($numberSeries);
        return $this;
    }

    /**
     * Sets the document serial number
     * 
     * @param int|null $documentSerialNumber The document serial number
     * @return self Returns this instance for method chaining
     */
    public function setDocumentSerialNumber(?int $documentSerialNumber): self
    {
        $this->documentSerialNumber->setValue($documentSerialNumber);
        return $this;
    }

    /**
     * Sets the center/cost center
     * 
     * @param string|null $center The center code
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
     * @param string|null $project The project code
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
     * @param string|null $activity The activity code
     * @return self Returns this instance for method chaining
     */
    public function setActivity(?string $activity): self
    {
        $this->activity->setValue($activity);
        return $this;
    }

    /**
     * Sets who issued the order
     * 
     * @param string|null $issuedBy The person who issued the order
     * @return self Returns this instance for method chaining
     */
    public function setIssuedBy(?string $issuedBy): self
    {
        $this->issuedBy->setValue($issuedBy);
        return $this;
    }

    /**
     * Sets whether items should not be reserved
     * 
     * @param bool|null $doNotReserve True if items should not be reserved
     * @return self Returns this instance for method chaining
     */
    public function setDoNotReserve(?bool $doNotReserve): self
    {
        $this->doNotReserve->setValue($doNotReserve);
        return $this;
    }

    /**
     * Sets whether prices are fixed
     * 
     * @param bool|null $fixedPrices True if prices are fixed
     * @return self Returns this instance for method chaining
     */
    public function setFixedPrices(?bool $fixedPrices): self
    {
        $this->fixedPrices->setValue($fixedPrices);
        return $this;
    }

    /**
     * Sets the payment terms
     * 
     * @param string|null $paymentTerms The payment terms
     * @return self Returns this instance for method chaining
     */
    public function setPaymentTerms(?string $paymentTerms): self
    {
        $this->paymentTerms->setValue($paymentTerms);
        return $this;
    }

    /**
     * Sets the shipping method
     * 
     * @param string|null $shipping The shipping method
     * @return self Returns this instance for method chaining
     */
    public function setShipping(?string $shipping): self
    {
        $this->shipping->setValue($shipping);
        return $this;
    }

    /**
     * Sets the title
     * 
     * @param string|null $title The order title
     * @return self Returns this instance for method chaining
     */
    public function setTitle(?string $title): self
    {
        $this->title->setValue($title);
        return $this;
    }

    /**
     * Sets the latest due date
     * 
     * @param DateTime|null $latestDueDate The latest completion date
     * @return self Returns this instance for method chaining
     */
    public function setLatestDueDate(?DateTime $latestDueDate): self
    {
        $this->latestDueDate->setValue($latestDueDate);
        return $this;
    }

    /**
     * Sets the type abbreviation
     * 
     * @param string|null $typeAbbreviation The type abbreviation
     * @return self Returns this instance for method chaining
     */
    public function setTypeAbbreviation(?string $typeAbbreviation): self
    {
        $this->typeAbbreviation->setValue($typeAbbreviation);
        return $this;
    }

    /**
     * Sets the primary document reference
     * 
     * @param string|null $primaryDocument The primary document reference
     * @return self Returns this instance for method chaining
     */
    public function setPrimaryDocument(?string $primaryDocument): self
    {
        $this->primaryDocument->setValue($primaryDocument);
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
     * Sets whether order should not be processed
     * 
     * @param bool|null $doNotProcess True if order should not be processed
     * @return self Returns this instance for method chaining
     */
    public function setDoNotProcess(?bool $doNotProcess): self
    {
        $this->doNotProcess->setValue($doNotProcess);
        return $this;
    }

    /**
     * Sets the VAT calculation method
     * 
     * @param int|null $vatCalculationMethod The VAT calculation method (1 = mathematical, 2 = coefficient)
     * @return self Returns this instance for method chaining
     */
    public function setVatCalculationMethod(?int $vatCalculationMethod): self
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
     * Sets the discount amount
     * 
     * @param float|null $discount The discount amount
     * @return self Returns this instance for method chaining
     */
    public function setDiscount(?float $discount): self
    {
        $this->discount->setValue($discount);
        return $this;
    }

    /**
     * Sets the list of order items
     * 
     * @param OrderItem[]|null $items Array of order items
     * @return self Returns this instance for method chaining
     */
    public function setItemsList(?array $items): self
    {
        $this->itemsList->setValue($items);
        return $this;
    }

    /**
     * Sets the company information for this order
     * 
     * @param string|null $company The company information
     * @return self Returns this instance for method chaining
     */
    public function setMyCompany(?string $company): self
    {
        $this->myCompany->setValue($company);
        return $this;
    }

    /**
     * Serializes the order to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement($this->orderType->getRootElement());

        $this->documentNumber->serialize($writer);
        $this->description->serialize($writer);
        $this->note->serialize($writer);
        $this->textBeforeItems->serialize($writer);
        $this->textAfterItems->serialize($writer);
        $this->issued->serialize($writer);
        $this->dueDate->serialize($writer);
        $this->completed->serialize($writer);
        $this->partner->serialize($writer);
        $this->finalRecipient->serialize($writer);
        $this->finalRecipientFromPartner->serialize($writer);
        $this->total->serialize($writer);
        $this->numberSeries->serialize($writer);
        $this->documentSerialNumber->serialize($writer);
        $this->center->serialize($writer);
        $this->project->serialize($writer);
        $this->activity->serialize($writer);
        $this->issuedBy->serialize($writer);
        $this->doNotReserve->serialize($writer);
        $this->fixedPrices->serialize($writer);
        $this->paymentTerms->serialize($writer);
        $this->shipping->serialize($writer);
        $this->title->serialize($writer);
        $this->latestDueDate->serialize($writer);
        $this->typeAbbreviation->serialize($writer);
        $this->primaryDocument->serialize($writer);
        $this->variableSymbol->serialize($writer);
        $this->doNotProcess->serialize($writer);
        $this->vatCalculationMethod->serialize($writer);
        $this->vatRate1->serialize($writer);
        $this->vatRate2->serialize($writer);
        $this->discount->serialize($writer);

        // Serialize items list
        if ($this->itemsList->getValue() !== null) {
            $items = $this->itemsList->getValue();
            foreach ($items as $item) {
                $writer->startElement("Polozka");
                $item->serialize($writer);
                $writer->endElement();
            }
        }

        $this->myCompany->serialize($writer);

        $writer->endElement();
    }
}
