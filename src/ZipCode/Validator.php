<?php

namespace CrazyFactory\Validation\ZipCode;

class Validator
{
    const EXAMPLES = [
        'AT' => ['1111'],
        'BE' => ['1111'],
        'BG' => ['1111'],
        'CH' => ['1111'],
        'CY' => ['1111'],
        'CZ' => ['111 11'],
        'DE' => ['11111'],
        'DK' => ['1111'],
        'EE' => ['11111'],
        'ES' => ['AD111','11111'],
        'FI' => ['11111'],
        'FR' => ['AD111','11111'],
        'GB' => ['AA11 1AA','A1A 1AA','AA1 1AA','AA1A 1AA','A11 1AA','A1 1AA'],
        'GR' => ['11111'],
        'HU' => ['1111'],
        // 'IE' too many variants
        'IT' => ['11111'],
        'LT' => ['11111'],
        'LU' => ['1111'],
        'LV' => ['1111'],
        'MC' => ['98111'],
        'MT' => ['AAA 1111'],
        'NL' => ['1111 AA'],
        'NO' => ['1111'],
        'PL' => ['11-111'],
        'PT' => ['1111-111'],
        'RO' => ['111111'],
        'SE' => ['111 11'],
        'SI' => ['1111'],
        'SK' => ['111 11'],
    ];

    const FORMATS = [
        'AT' => '[1-9]{1}[0-9]{3}',
        'BE' => '[1-9]\\d{3}',
        'BG' => '[1-9]{1}[0-9]{3}',
        'CH' => '[1-9]{1}[0-9]{3}',
        'CY' => '[1-9]\\d{3}',
        'CZ' => '\\d{3}\\s\\d{2}',
        'DE' => '[0-9]{5}',
        'DEFAULT' => '[0-9A-Z]',
        'DK' => '\\d{4}',
        'EE' => '[1-9]{1}[0-9]{4}',
        'ES' => '(AD{0,1}\\d{3})|\\d{5}',
        'FI' => '\\d{5}',
        'FR' => '(AD{0,1}\\d{3})|\\d{5}',
        'GB' => '[A-Z\\d]{2,4}\\s\\d[A-Z]{2}',
        'GR' => '[1-9]{1}[0-9]{4}',
        'HU' => '\\d{4}',
        'IE' => '[-1-9]{1}',
        'IT' => '\\d{5}',
        'LT' => '\\d{5}',
        'LU' => '[1-9]\\d{3}',
        'LV' => '[1-9]{1}\\d{3}',
        'MC' => '98[0-9]{3}',
        'MT' => '[A-Z]{3}\\s[1-9]{1}[0-9]{3}',
        'NL' => '[1-9]\\d{3}\\s[A-Z]{2}',
        'NO' => '\\d{4}',
        'PL' => '\\d{2}-\\d{3}',
        'PT' => '[1-9]{1}[0-9]{3}-\\d{3}',
        'RO' => '\\d{6}',
        'SE' => '\\d{3}\\s\\d{2}',
        'SI' => '\\d{4}',
        'SK' => '\\d{3}\\s\\d{2}',
    ];

    /**
     * Validate if a given zip code is valid for the given country.
     *
     * @param  string  $zipCode
     * @param  string  $countryCode
     *
     * @return bool
     */
    public function validate(string $zipCode, string $countryCode): bool
    {
        if (isset(static::FORMATS[$countryCode])) {
            $regex = '/^' . static::FORMATS[$countryCode] . '$/';
        }
        else {
            $regex = '/' . static::FORMATS['DEFAULT'] . '/';
        }

        return preg_match($regex, $zipCode) > 0;
    }

    /**
     * Validate if a given zip code is valid for the given country.
     *
     * Static alias of validate().
     *
     * @param  string  $zipCode
     * @param  string  $countryCode
     *
     * @return bool
     */
    public static function isValid(string $zipCode, string $countryCode): bool
    {
        static $instance;

        if (!$instance) {
            $instance = new static;
        }

        return $instance->validate($zipCode, $countryCode);
    }
}
