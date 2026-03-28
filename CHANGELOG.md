# Changelog

All notable changes to `feedex/coinex` are documented in this file.

The format is inspired by [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and this project uses semantic version tags.

## [Unreleased]

## [1.0.0]

### Stable release
- Promoted CoinEx adapter API surface to stable `1.0.0`.
- Updated core dependency to `feedex/feedex ^1.0`.
- Preserved existing documented module/capability surface finalized during freeze.

## [0.2.10]

### Docs
- Added explicit coinex v1.0.0 scope freeze notes.
- Aligned changelog entries for pre-v1 release stream.

## [0.2.9]

### Changed
- Adopt granular core capability interfaces from `feedex/feedex ^0.1.6`.

## [0.2.8]

### Docs
- Add endpoint coverage table in README.
- Add runnable `examples/` scripts for balances, spot order, and futures order.
- Add changelog file for clearer release history.

## [0.2.7]

### Tests
- Add mocked HTTP integration tests for query/body/signature serialization edge-cases.
- Add golden signature vector tests for tricky query+body payload combinations.

## [0.2.6]

### Added
- Lightweight payload builders for spot/futures order calls.
- Typed exception mapping for auth, rate-limit, validation, and transient failures.
- Optional retry/backoff strategy in HTTP client (disabled by default).

## [0.2.5]

### Added
- Account Sub module.
- Asset Transfer module.
- Asset Deposit/Withdrawal module.
- Asset Loan module.

## [0.2.4]

### Added
- Futures Position module and tests.

## [0.2.3]

### Fixed
- Core dependency constraint alignment.

## [0.2.2]

### Changed
- Futures Deal alignment with Feedex core contracts/capabilities.

## [0.2.1]

### Changed
- Futures module alignment with Feedex core contracts.

## [0.2.0]

### Added
- Spot batch/stop order support.
- Futures market and order modules.

## [0.1.1]

### Added
- Spot market/order/deal enhancements and test coverage updates.

## [0.1.0]

### Added
- Initial Feedex CoinEx v2 adapter release.
