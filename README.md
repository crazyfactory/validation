# Validation Helpers

This repo contains Helper classes used for various Validation tasks

## Example usage

```php
use CrazyFactory\Validation\ZipCode\Validator as ZipCodeValidator;
use CrazyFactory\Validation\ZipCode\Sanitizer as ZipCodeSanitizer;

$isValidZipCode = ZipCodeValidator::isValid($zipCode, $countryCode);
// => bool

$zipCode = ZipCodeSanitizer::sanitize($zipCode, $countryCode);
// => a sanitized and valid zip code (original code on failure)
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
