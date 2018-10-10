# Validation Helpers

This repo contains Helper classes used for various Validation tasks

## Example usage

```
    $isValidZipCode = ZipCodeValidator::isValid($CountryCode, $ZipCode);
```

## Requirements
- php:  *>7.1*
- composer installed


## Scripts

Run Tests

```bash
composer test
```

### Lint

```bash
composer lint
```

#### Auto-fix of linting errors

```bash
composer lint:fix
```
