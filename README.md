# NextAccountingDay - Dolibarr Module

Utility module for accounting period management. Provides functions to calculate the next accounting day and manage fiscal years.

## Features

- Next accounting day calculation
- Accounting period management
- Dolibarr 16 compatibility via backport

---

## Installation

### Prerequisites

- Dolibarr >= 11.0
- PHP >= 7.0

### Module Installation

1. Copy the `nextaccountingday` folder into `htdocs/custom/`
2. Enable the module in **Setup > Modules > Interface**

---

## Usage

This module is primarily used by other modules that need to calculate accounting dates. It exposes utility functions via its library.

---

## Architecture

### File Structure

```
nextaccountingday/
├── core/modules/
│   └── modNextAccountingDay.class.php  # Module descriptor
├── admin/
│   ├── setup.php                       # Configuration
│   └── about.php                       # About
├── lib/
│   └── nextaccountingday.lib.php       # Calculation functions
├── js/
│   └── nextaccountingday.js.php        # JavaScript
├── backport/v16/                       # Dolibarr 16 compatibility
├── test/phpunit/                       # Functional tests
└── sql/                                # Minimal
```

### Available Functions

Functions are exposed in `lib/nextaccountingday.lib.php`:

```php
// Usage example
dol_include_once('/nextaccountingday/lib/nextaccountingday.lib.php');

// Calculate the next accounting day
$nextDay = getNextAccountingDay($currentDate);
```

---

## Development

### Dolibarr 16 Compatibility

The `backport/v16/` folder contains adaptations for Dolibarr 16.

### Tests

```bash
cd htdocs/custom/nextaccountingday/test/phpunit
phpunit
```

---

## License

GPLv3 - See COPYING file
