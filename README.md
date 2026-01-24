# NextAccountingDay - Dolibarr Module

Adds a "Next" button next to date fields on accounting pages to automatically fill in the next business day (weekday).

## Features

- Adds a "Next" button next to date input fields
- Automatically calculates the next weekday (Monday-Friday)
- Works on specific accounting pages:
  - Salaries
  - Social charges
  - Bank various payments
  - Supplier invoices
  - Expense reports
- Dolibarr 11+ compatibility (with v16 FormSetup backport)

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

Once enabled, a "Next" button appears next to date fields on supported pages. Clicking it fills the date with the next business day.

---

## Architecture

### File Structure

```
nextaccountingday/
├── core/modules/
│   └── modNextAccountingDay.class.php  # Module descriptor
├── admin/
│   ├── setup.php                       # Configuration page
│   └── about.php                       # About page
├── lib/
│   └── nextaccountingday.lib.php       # Admin helper functions
├── js/
│   └── nextaccountingday.js.php        # JavaScript (main functionality)
├── langs/                              # Translations (en_US, fr_FR, fr_CH)
├── backport/v16/                       # Dolibarr < 16 compatibility
└── test/phpunit/                       # Functional tests
```

---

## Development

### How it works

The module loads a JavaScript file on all pages. The script checks if the current page URL matches one of the supported paths (salaries, social charges, etc.). If it does, it adds a "Next" button after each date input field.

### Dolibarr < 16 Compatibility

The `backport/v16/` folder contains FormSetup class for Dolibarr versions prior to 16.0.

---

## License

GPLv3 - See COPYING file
