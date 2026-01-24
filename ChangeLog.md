# CHANGELOG NEXTACCOUNTINGDAY FOR [DOLIBARR ERP CRM](https://www.dolibarr.org)

## 1.2 (Unreleased)

### Changed
- Cleaned up module code by removing MYOBJECT/MYMODULE template references
- Simplified setup.php (no settings needed for this module)
- Updated language files with proper translations
- Updated build workflow with release trigger and automatic version bump PR

### Fixed
- Fixed French language files that had MYMODULE references instead of NextAccountingDay

## 1.1

### Added
- Added expense report pages to the list of supported pages
- Added build workflow for release packaging

### Changed
- Limited the module to specific accounting pages (salaries, social charges, bank payments, supplier invoices, expense reports)
- Updated documentation and README

## 1.0

### Added
- Initial version
- Adds a "Next" button next to date fields on accounting pages
- Automatically fills the date with the next business day (weekday)
- Supports pages: salaries, social charges, bank various payments, supplier invoices, expense reports
