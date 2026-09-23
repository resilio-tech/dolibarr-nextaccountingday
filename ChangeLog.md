# CHANGELOG NEXTACCOUNTINGDAY FOR [DOLIBARR ERP CRM](https://www.dolibarr.org)

## Unreleased

### Build
- Stop the release build from pushing the version bump to main, which the branch protection rejects. The descriptor is now bumped in the pull request that prepares a release, and the build refuses a tag that does not match it
- Build on a `v*` tag push as well as on a published release
- Pass the workflow inputs and the tag name through the environment and validate the version, so a crafted value cannot run as shell code
- Rename the version bump workflow to `version-bump.yml` and stop it writing a placeholder entry in this changelog
- Realign this changelog with the published tags: the 1.2 changes were released as 1.0.0

### Changed
- Drop the unused `temp` data directory from the module descriptor

## 1.0.0

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
