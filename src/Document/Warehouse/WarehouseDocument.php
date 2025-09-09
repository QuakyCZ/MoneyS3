<?php

namespace eProduct\MoneyS3\Document\Warehouse;

use DateTime;
use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Document\IDocument;
use eProduct\MoneyS3\Element;
use XMLWriter;

class WarehouseDocument implements IDocument
{
    /** @var Element<string> */
    private Element $documentNumber;

    /** @var Element<int> */
    private Element $accountingMethod;

    /** @var Element<string> */
    private Element $orderNumber;

    /** @var Element<bool> */
    private Element $finalRecipientFromPartner;

    /** @var Element<DateTime> */
    private Element $date;

    /** @var Element<float> */
    private Element $total;

    /** @var Element<string> */
    private Element $numberSeries;

    /** @var Element<string> */
    private Element $center;

    /** @var Element<string> */
    private Element $project;

    /** @var Element<string> */
    private Element $activity;

    /** @var Element<string> */
    private Element $issuedBy;

    /** @var Element<string> */
    private Element $mosscode;

    /** @var Element<int> */
    private Element $vatCalculationMethod;

    /** @var Element<int> */
    private Element $vatRate1;

    /** @var Element<int> */
    private Element $vatRate2;

    /** @var Element<string> */
    private Element $primaryDocument;

    /** @var Element<string> */
    private Element $variableSymbol;

    /** @var Element<string> */
    private Element $pairingSymbol;

    /** @var Element<string> */
    private Element $partner;

    /** @var Element<Address> */
    private Element $finalRecipient;

    /** @var Element<string> */
    private Element $transactionType;

    /** @var Element<string> */
    private Element $deliveryTerms;

    /** @var Element<string> */
    private Element $transportType;

    /** @var Element<string> */
    private Element $originDestinationState;

    /** @var Element<string> */
    private Element $intrastatCode;

    /** @var Element<string> */
    private Element $intrastatVatId;

    /** @var Element<float> */
    private Element $domesticTransport;

    /** @var Element<float> */
    private Element $foreignTransport;

    /** @var Element<DateTime> */
    private Element $intrastatDate;

    /** @var Element<float> */
    private Element $discount;

    /** @var Element<WarehouseItem[]> */
    private Element $itemsList;

    /** @var Element<string> */
    private Element $myCompany;

    /**
     * Constructor for WarehouseDocument class
     * 
     * @param WarehouseType $warehouseType The type of warehouse document
     */
    public function __construct(public readonly WarehouseType $warehouseType)
    {
        $this->documentNumber = new Element("CisloDokla", true);
        $this->accountingMethod = new Element("ZpusobUctovani");
        $this->orderNumber = new Element("CObjednavk");
        $this->finalRecipientFromPartner = new Element("KPFromOdb");
        $this->date = new Element("Datum");
        $this->total = new Element("Celkem");
        $this->numberSeries = new Element("DRada");
        $this->center = new Element("Stredisko");
        $this->project = new Element("Zakazka");
        $this->activity = new Element("Cinnost");
        $this->issuedBy = new Element("Vystavil");
        $this->mosscode = new Element("StatMOSS");
        $this->vatCalculationMethod = new Element("ZpVypDPH");
        $this->vatRate1 = new Element("SazbaDPH1");
        $this->vatRate2 = new Element("SazbaDPH2");
        $this->primaryDocument = new Element("PrimDoklad");
        $this->variableSymbol = new Element("VarSymbol");
        $this->pairingSymbol = new Element("ParSymbol");
        $this->partner = new Element("DodOdb");
        $this->finalRecipient = new Element("KonecPrij");
        $this->transactionType = new Element("TypTransakce");
        $this->deliveryTerms = new Element("DodaciPodm");
        $this->transportType = new Element("DruhDopravy");
        $this->originDestinationState = new Element("StOdeslUrc");
        $this->intrastatCode = new Element("IstatKodOd");
        $this->intrastatVatId = new Element("IstatDIC");
        $this->domesticTransport = new Element("DopravTuz");
        $this->foreignTransport = new Element("DopravZahr");
        $this->intrastatDate = new Element("DatumITS");
        $this->discount = new Element("Sleva");
        $this->itemsList = new Element("Polozka");
        $this->myCompany = new Element("MojeFirma");
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
     * Sets the order number
     * 
     * @param string|null $orderNumber The order number (only for delivery notes and sales receipts)
     * @return self Returns this instance for method chaining
     */
    public function setOrderNumber(?string $orderNumber): self
    {
        $this->orderNumber->setValue($orderNumber);
        return $this;
    }

    /**
     * Sets whether final recipient address should be taken from partner
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
     * Sets the document date
     * 
     * @param DateTime|null $date The document date
     * @return self Returns this instance for method chaining
     */
    public function setDate(?DateTime $date): self
    {
        $this->date->setValue($date);
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
     * Sets the number series abbreviation
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
     * Sets who issued the document
     * 
     * @param string|null $issuedBy The person who issued the document
     * @return self Returns this instance for method chaining
     */
    public function setIssuedBy(?string $issuedBy): self
    {
        $this->issuedBy->setValue($issuedBy);
        return $this;
    }

    /**
     * Sets the MOSS state code
     * 
     * @param string|null $mosscode The MOSS state code (only for certain document types)
     * @return self Returns this instance for method chaining
     */
    public function setMossCode(?string $mosscode): self
    {
        $this->mosscode->setValue($mosscode);
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
     * Sets the first VAT rate
     * 
     * @param int|null $vatRate1 The reduced VAT rate in percentage
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
     * @param int|null $vatRate2 The standard VAT rate in percentage
     * @return self Returns this instance for method chaining
     */
    public function setVatRate2(?int $vatRate2): self
    {
        $this->vatRate2->setValue($vatRate2);
        return $this;
    }

    /**
     * Sets the primary document reference
     * 
     * @param string|null $primaryDocument The received document number
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
     * Sets the business partner
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
     * Sets the final recipient address
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
     * Sets the transaction type for Intrastat
     * 
     * @param string|null $transactionType The transaction type (2 characters)
     * @return self Returns this instance for method chaining
     */
    public function setTransactionType(?string $transactionType): self
    {
        $this->transactionType->setValue($transactionType);
        return $this;
    }

    /**
     * Sets the delivery terms for Intrastat
     * 
     * @param string|null $deliveryTerms The delivery terms (3 characters max)
     * @return self Returns this instance for method chaining
     */
    public function setDeliveryTerms(?string $deliveryTerms): self
    {
        $this->deliveryTerms->setValue($deliveryTerms);
        return $this;
    }

    /**
     * Sets the transport type for Intrastat
     * 
     * @param string|null $transportType The transport type (1 character)
     * @return self Returns this instance for method chaining
     */
    public function setTransportType(?string $transportType): self
    {
        $this->transportType->setValue($transportType);
        return $this;
    }

    /**
     * Sets the origin/destination state for Intrastat
     * 
     * @param string|null $originDestinationState The origin or destination state
     * @return self Returns this instance for method chaining
     */
    public function setOriginDestinationState(?string $originDestinationState): self
    {
        $this->originDestinationState->setValue($originDestinationState);
        return $this;
    }

    /**
     * Sets the Intrastat code for customers without VAT ID
     * 
     * @param string|null $intrastatCode The Intrastat code
     * @return self Returns this instance for method chaining
     */
    public function setIntrastatCode(?string $intrastatCode): self
    {
        $this->intrastatCode->setValue($intrastatCode);
        return $this;
    }

    /**
     * Sets the alternative VAT ID for Intrastat
     * 
     * @param string|null $intrastatVatId The alternative VAT ID
     * @return self Returns this instance for method chaining
     */
    public function setIntrastatVatId(?string $intrastatVatId): self
    {
        $this->intrastatVatId->setValue($intrastatVatId);
        return $this;
    }

    /**
     * Sets the domestic transport costs
     * 
     * @param float|null $domesticTransport The domestic transport costs
     * @return self Returns this instance for method chaining
     */
    public function setDomesticTransport(?float $domesticTransport): self
    {
        $this->domesticTransport->setValue($domesticTransport);
        return $this;
    }

    /**
     * Sets the foreign transport costs
     * 
     * @param float|null $foreignTransport The foreign transport costs
     * @return self Returns this instance for method chaining
     */
    public function setForeignTransport(?float $foreignTransport): self
    {
        $this->foreignTransport->setValue($foreignTransport);
        return $this;
    }

    /**
     * Sets the Intrastat date
     * 
     * @param DateTime|null $intrastatDate The Intrastat date
     * @return self Returns this instance for method chaining
     */
    public function setIntrastatDate(?DateTime $intrastatDate): self
    {
        $this->intrastatDate->setValue($intrastatDate);
        return $this;
    }

    /**
     * Sets the total discount for the document
     * 
     * @param float|null $discount The total discount amount
     * @return self Returns this instance for method chaining
     */
    public function setDiscount(?float $discount): self
    {
        $this->discount->setValue($discount);
        return $this;
    }

    /**
     * Sets the list of warehouse items
     * 
     * @param WarehouseItem[]|null $items Array of warehouse items
     * @return self Returns this instance for method chaining
     */
    public function setItemsList(?array $items): self
    {
        $this->itemsList->setValue($items);
        return $this;
    }

    /**
     * Sets the company information
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
     * Serializes the warehouse document to XML
     * 
     * @param XMLWriter $writer The XMLWriter instance to write to
     * @return void
     */
    public function serialize(XMLWriter $writer): void
    {
        $writer->startElement($this->warehouseType->getRootElement());

        $this->documentNumber->serialize($writer);
        $this->accountingMethod->serialize($writer);
        $this->orderNumber->serialize($writer);
        $this->finalRecipientFromPartner->serialize($writer);
        $this->date->serialize($writer);
        $this->total->serialize($writer);
        $this->numberSeries->serialize($writer);
        $this->center->serialize($writer);
        $this->project->serialize($writer);
        $this->activity->serialize($writer);
        $this->issuedBy->serialize($writer);
        $this->mosscode->serialize($writer);
        $this->vatCalculationMethod->serialize($writer);
        $this->vatRate1->serialize($writer);
        $this->vatRate2->serialize($writer);
        $this->primaryDocument->serialize($writer);
        $this->variableSymbol->serialize($writer);
        $this->pairingSymbol->serialize($writer);
        $this->partner->serialize($writer);
        $this->finalRecipient->serialize($writer);
        $this->transactionType->serialize($writer);
        $this->deliveryTerms->serialize($writer);
        $this->transportType->serialize($writer);
        $this->originDestinationState->serialize($writer);
        $this->intrastatCode->serialize($writer);
        $this->intrastatVatId->serialize($writer);
        $this->domesticTransport->serialize($writer);
        $this->foreignTransport->serialize($writer);
        $this->intrastatDate->serialize($writer);
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
