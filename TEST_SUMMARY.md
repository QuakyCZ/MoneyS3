# MoneyS3 Library Test Suite

This document provides an overview of the comprehensive unit test suite implemented for the MoneyS3 library.

## Test Structure

The test suite is organized into the following categories:

### Unit Tests
- **ElementTest** - Tests for the core Element class functionality
- **MoneyS3Test** - Tests for the main MoneyS3 class
- **MoneyS3DataTest** - Tests for the internal data handling class
- **InvoiceTest** - Tests for Invoice document functionality
- **InvoiceTypeTest** - Tests for the InvoiceType enum
- **ReceiptTest** - Tests for Receipt document functionality
- **MoneyS3ExceptionTest** - Tests for exception handling

### Integration Tests
- **MoneyS3IntegrationTest** - End-to-end tests for complete workflows

## Test Coverage

### Core Functionality
- **MoneyS3 Class**: Constructor, invoice/receipt creation, XML generation
- **Element Class**: Value setting/getting, serialization, required field validation
- **MoneyS3Data Class**: Data organization, serialization of multiple documents
- **Exception Handling**: Custom exception behavior and inheritance

### Document Types
- **Invoice**: All setter methods, fluent interface, serialization for both issued and received invoices
- **InvoiceType Enum**: Type-specific XML element names and validation
- **Receipt**: Basic serialization and XML structure

### XML Generation
- **Valid XML Structure**: Well-formed XML output validation
- **Attribute Handling**: ICO and language version attributes
- **Multiple Documents**: Handling of multiple invoices and receipts
- **Empty Documents**: Proper handling of empty data sets

### Integration Scenarios
- **Complete Workflow**: Full invoice creation and XML generation
- **Mixed Content**: Multiple invoice types and receipts together
- **Large Volume**: Performance testing with multiple documents
- **Fluent Interface**: Method chaining validation
- **XML Validation**: DOM validation of generated XML

## Test Statistics
- **Total Tests**: 61
- **Total Assertions**: 193
- **Coverage Areas**: 
  - Core classes (MoneyS3, Element, MoneyS3Data)
  - Document types (Invoice, Receipt)
  - Exception handling
  - XML generation and validation
  - Integration workflows

## Key Features Tested

### Fluent Interface
Tests verify that all setter methods return the invoice instance for method chaining:
```php
$invoice->setDocumentNumber('2023001')
        ->setDescription('Test Invoice')
        ->setTotal('1000.00');
```

### XML Structure Validation
All generated XML is validated for:
- Well-formed structure
- Correct element names and attributes
- Proper encoding and document declaration

### Error Handling
- Required field validation
- Exception inheritance and messaging
- Graceful handling of empty data

### Performance
- Large volume data handling (tested with 10+ documents)
- Memory usage validation
- XML generation efficiency

## Running the Tests

```bash
# Run all tests
vendor/bin/phpunit

# Run with readable output
vendor/bin/phpunit --no-configuration tests/ --testdox

# Run specific test class
vendor/bin/phpunit tests/MoneyS3Test.php

# Run with coverage (requires Xdebug)
vendor/bin/phpunit --coverage-html coverage
```

## Test Files Structure

```
test/
├── MoneyS3Test.php                     # Main class tests
├── ElementTest.php                     # Element class tests
├── MoneyS3DataTest.php                 # Data handling tests
├── Document/
│   ├── Invoice/
│   │   ├── InvoiceTest.php            # Invoice functionality
│   │   └── InvoiceTypeTest.php        # Invoice type enum
│   └── Receipt/
│       └── ReceiptTest.php            # Receipt functionality
├── Exception/
│   └── MoneyS3ExceptionTest.php       # Exception handling
└── Integration/
    └── MoneyS3IntegrationTest.php     # End-to-end tests
```

This comprehensive test suite ensures the reliability and correctness of the MoneyS3 library across all its functionality areas.
