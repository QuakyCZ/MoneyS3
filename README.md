# MoneyS3 PHP Library

A PHP library for generating XML data compatible with MoneyS3 accounting software. This library provides a simple and intuitive API for creating invoices and receipts in the MoneyS3 XML format.

[![Version](https://img.shields.io/badge/version-0.0.1-blue.svg)]()
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.3-blue.svg)](https://php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## Supported Documents

| Document Type | Status | XML Element | Description |
|---------------|--------|-------------|-------------|
| Issued Invoice | ✅ Done | `FaktVyd` | Outgoing invoices sent to customers |
| Received Invoice | ✅ Done | `FaktPrij` | Incoming invoices from suppliers |
| Receipt | ✅ Done | `Prijemka` | Receipt documents for goods/services |
| Obligation | ✅ Done | `Zavazek` | Financial obligations |

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [API Reference](#api-reference)
  - [MoneyS3 Class](#moneys3-class)
  - [Invoice Management](#invoice-management)
  - [Receipt Management](#receipt-management)
  - [Supporting Classes](#supporting-classes)
- [Examples](#examples)
- [Development](#development)
- [Testing](#testing)
- [License](#license)

## Requirements

- PHP 8.3 or higher
- ext-xmlwriter extension

## Installation

Install the package via Composer:

```bash
composer require eproduct/money-s3
```

## Basic Usage

```php
<?php

use eProduct\MoneyS3\MoneyS3;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\Document\Common\Partner;
use eProduct\MoneyS3\Document\Invoice\Company;
use eProduct\MoneyS3\Document\Common\Address;

// Initialize MoneyS3 with your company ICO
$moneyS3 = new MoneyS3('12345678');

// Create an issued invoice
$invoice = $moneyS3->addInvoice(InvoiceType::ISSUED)
    ->setDocumentNumber('VF2025090001')
    ->setDescription('Test Invoice')
    ->setIssued(new DateTime('2025-09-08'))
    ->setDueDate(new DateTime('2025-09-22'))
    ->setVariableSymbol('2025090001')
    ->setTotal(1000.00);

// Add a receipt
$receipt = $moneyS3->addReceipt();

// Generate XML
$xml = $moneyS3->getXmls();
echo $xml;
```

## API Reference

### MoneyS3 Class

The main class for managing MoneyS3 data and generating XML output.

#### Constructor

```php
public function __construct(string $ico)
```

- `$ico`: Company identification number (ICO)

#### Methods

##### `addInvoice(InvoiceType $type): Invoice`

Creates and adds a new invoice to the data collection.

- `$type`: Invoice type (`InvoiceType::ISSUED` or `InvoiceType::RECEIVED`)
- Returns: `Invoice` instance for method chaining

##### `addReceipt(): Receipt`

Creates and adds a new receipt to the data collection.

- Returns: `Receipt` instance for method chaining

##### `getXml(bool $flushMemory = true): string`

Generates XML representation of all data.

- `$flushMemory`: Whether to clear internal data after generating XML (default: `true`)
- Returns: Complete XML document as string

### Invoice Management

#### InvoiceType Enum

```php
enum InvoiceType: string
{
    case ISSUED = 'issued';      // Vydané faktury
    case RECEIVED = 'received';  // Přijaté faktury
}
```

#### Invoice Class

Represents an invoice with comprehensive configuration options.

##### Key Methods

```php
// Document identification
setDocumentNumber(string $documentNumber): self
setDescription(string $description): self
setVariableSymbol(string $variableSymbol): self

// Dates
setIssued(DateTime $issued): self
setAccountingDate(DateTime $accountingDate): self
setDueDate(DateTime $dueDate): self
setTaxDocumentDate(DateTime $taxDocumentDate): self

// Financial information
setTotal(float $total): self
setToPay(float $toPay): self
setVatRate1(int $vatRate1): self
setVatRate2(int $vatRate2): self

// Business entities
setPartner(Partner $partner): self
setMyCompany(Company $company): self

// Additional properties
setType(string $type): self
setAccount(string $account): self
setSettled(bool $settled): self
setCreditNote(bool $creditNote): self
setSimplified(bool $simplified): self
```

### Receipt Management

#### Receipt Class

Represents a simple receipt document.

```php
$receipt = $moneyS3->addReceipt();
```

Currently provides basic receipt structure. Additional properties can be added as needed.

### Supporting Classes

#### Partner Class

Represents business partner information for invoices.

```php
$partner = (new Partner())
    ->setName('Company Name')
    ->setIco('12345678')
    ->setAddress($address)
    ->setVatPayer(true)
    ->setPhysicalPerson(false);
```

#### Company Class

Represents your company information.

```php
$company = (new Company())
    ->setInvoiceName('My Company Ltd.')
    ->setInvoiceAddress($address)
    ->setIco('87654321')
    ->setDic('CZ87654321')
    ->setCurrencySymbol('Kč')
    ->setCurrencyCode('CZK');
```

#### Address Class

Represents address information for companies and partners.

```php
$address = (new Address())
    ->setStreet('Main Street 123')
    ->setCity('Prague')
    ->setPostalCode('11000')
    ->setCountry('Czech Republic')
    ->setCountryCode('CZ');
```

#### VatSummary Class

Represents VAT summary information.

```php
$vatSummary = (new VatSummary())
    ->setBase22(826.45)    // Base amount for 22% VAT
    ->setVat22(173.55);    // VAT amount for 22% rate
```

## Examples

### Complete Invoice Example

```php
<?php

use eProduct\MoneyS3\Document\Common\Address;
use eProduct\MoneyS3\Document\Common\Partner;
use eProduct\MoneyS3\Document\Common\VatSummary;
use eProduct\MoneyS3\Document\Invoice\Company;
use eProduct\MoneyS3\Document\Invoice\InvoiceType;
use eProduct\MoneyS3\MoneyS3;

$moneyS3 = new MoneyS3('12345678');

$invoice = $moneyS3->addInvoice(InvoiceType::ISSUED)
    ->setDocumentNumber('VF2025090001')
    ->setAccountingMethod(1)
    ->setDescription('Software Development Services')
    ->setIssued(new DateTime('2025-09-08'))
    ->setAccountingDate(new DateTime('2025-09-08'))
    ->setTaxDocumentDate(new DateTime('2025-09-08'))
    ->setDueDate(new DateTime('2025-09-22'))
    ->setSimplified(false)
    ->setVariableSymbol('2025090001')
    ->setAccount('BAN')
    ->setType('N')
    ->setCreditNote(false)
    ->setVatRate1(12)
    ->setVatRate2(21)
    ->setToPay(1210.00)
    ->setSettled(false)
    ->setVatSummary(
        (new VatSummary())
            ->setBase22(1000.00)
            ->setVat22(210.00)
    )
    ->setTotal(1210.00)
    ->setPartner(
        (new Partner())
            ->setName('Client Company s.r.o.')
            ->setAddress((new Address())
                ->setStreet('Business Street 456')
                ->setCity('Brno')
                ->setPostalCode('60200')
                ->setCountry('Czech Republic')
                ->setCountryCode('CZ')
            )
            ->setIco('98765432')
            ->setVatPayer(true)
            ->setPhysicalPerson(false)
    )
    ->setMyCompany(
        (new Company())
            ->setInvoiceName('My Software Company s.r.o.')
            ->setInvoiceAddress(
                (new Address())
                    ->setStreet('Development Ave 1')
                    ->setCity('Prague')
                    ->setPostalCode('11000')
                    ->setCountry('Czech Republic')
                    ->setCountryCode('CZ')
            )
            ->setIco('12345678')
            ->setDic('CZ12345678')
            ->setPhysicalPerson(false)
            ->setCurrencySymbol('Kč')
            ->setCurrencyCode('CZK')
    );

// Generate and save XML
$xml = $moneyS3->getXmls();
file_put_contents('invoices.xml', $xml);
```

### Multiple Invoices Example

```php
$moneyS3 = new MoneyS3('12345678');

// Add issued invoice
$moneyS3->addInvoice(InvoiceType::ISSUED)
    ->setDocumentNumber('VF001')
    ->setDescription('Service A')
    ->setTotal(1000.00);

// Add received invoice
$moneyS3->addInvoice(InvoiceType::RECEIVED)
    ->setDocumentNumber('PF001')
    ->setDescription('Purchase B')
    ->setTotal(500.00);

// Add receipt
$moneyS3->addReceipt();

$xml = $moneyS3->getXml();
```

### Batch Processing with Memory Management

```php
$moneyS3 = new MoneyS3('12345678');

// Process invoices in batches
foreach ($invoiceDataBatches as $batch) {
    foreach ($batch as $data) {
        $moneyS3->addInvoice(InvoiceType::ISSUED)
            ->setDocumentNumber($data['number'])
            ->setDescription($data['description'])
            ->setTotal($data['total']);
    }
    
    // Generate XML and clear memory
    $xml = $moneyS3->getXml(true); // true flushes memory
    
    // Process or save XML
    processXml($xml);
}
```

## Development

### Prerequisites

- Docker and Docker Compose
- Make

### Setup Development Environment

```bash
# Start development environment
make up

# Install dependencies
make install

# Run static analysis
make phpstan

# Run tests
make test

# Stop environment
make down
```

### Available Make Commands

- `make up` - Start Docker containers
- `make down` - Stop Docker containers
- `make install` - Install Composer dependencies
- `make update` - Update Composer dependencies
- `make phpstan` or `make ps` - Run PHPStan static analysis
- `make test` - Run PHPUnit tests

## Testing

The library includes comprehensive tests covering:

- XML generation and validation
- Invoice creation and configuration
- Receipt management
- Multiple document types
- Well-formed XML output

Run tests using:

```bash
make test
```

Or with Docker directly:

```bash
docker exec -it eproduct-moneys3 vendor/bin/phpunit --colors=always --testdox tests
```

## XML Output Structure

The generated XML follows the [MoneyS3 format](https://money.cz/navod/s3xmlde/):

```xml
<?xml version="1.0" encoding="UTF-8"?>
<MoneyData ICAgendy="12345678" JazykVerze="CZ">
    <SeznamFaktVyd>
        <FaktVyd>
            <!-- Issued invoice data -->
        </FaktVyd>
    </SeznamFaktVyd>
    <SeznamFaktPrij>
        <FaktPrij>
            <!-- Received invoice data -->
        </FaktPrij>
    </SeznamFaktPrij>
    <Prijemka>
        <!-- Receipt data -->
    </Prijemka>
</MoneyData>
```

## Error Handling

The library uses type-safe approach with PHP 8.3+ features:

- Enum types for invoice types
- Strict typing throughout the API
- PHPStan level 9 compliance
- Comprehensive exception handling

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Authors

**Tomáš Kratschmer**
- Email: info@quaky.cz

**Lukáš Chytil**
- Email: chytil.lukas3@gmail.com

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Changelog

### Version 0.0.1
- Initial release
- Invoice agenda (issued/received)
- Receipt agenda
- Obligation agenda
- XML generation
- Comprehensive test suite
- Docker development environment

## ⚠️ Disclaimer

**This library is not affiliated with, endorsed by, or associated with MoneyS3 accounting software, Seyfor a. s. company, or its developers.** MoneyS3 is a trademark of Seyfor, a.s. This is an independent, open-source library created to generate XML files compatible with the MoneyS3 XML import format. Use of this library is at your own risk, and the authors are not responsible for any data loss or accounting errors that may result from its use.