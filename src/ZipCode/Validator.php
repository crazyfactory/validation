<?php

namespace CrazyFactory\Validation\ZipCode;

/**
 * Ireland has special rules.
 * We need to enter zip code as `-` and precede city with zip code.
 * We handle this in ERP.
 *
 * Class Validator
 * @package CrazyFactory\Validation\ZipCode
 */
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
        'HR' => ['11111'],
        'HU' => ['1111'],
        'IE' => ['A11 A111','A11 AA11', 'A11 AAA1','A11 AAAA','A11 A11A','A11 A1A1','D6W A111','D6W AA11','D6W AAA1','D6W AAAA','D6W A11A','D6W A1A1'],
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
        'AE' => ['00000', 'N/A'],
        'AU' => ['00000', 'N/A'],
        'BA' => ['00000', 'N/A'],
        'CO' => ['00000', 'N/A'],
        'QA' => ['00000', 'N/A'],
    ];

    const FORMATS = [
        'AT' => '[1-9]{1}[0-9]{3}',
        'BE' => '[1-9]\\d{3}',
        'BG' => '[1-9]{1}[0-9]{3}',
        'CH' => '[1-9]{1}[0-9]{3}',
        'CY' => '[1-9]\\d{3}',
        'CZ' => '\\d{3}\\s\\d{2}',
        'DE' => '[0-9]{5}',
        'DEFAULT' => '[0-9A-Z\-]{1,10}',
        'DK' => '\\d{4}',
        'EE' => '[1-9]{1}[0-9]{4}',
        'ES' => '(AD{0,1}\\d{3})|^\\d{5}',
        'FI' => '\\d{5}',
        'FR' => '(AD{0,1}\\d{3})|^\\d{5}',
        'GB' => '[A-Z\\d]{2,4}\\s\\d[A-Z]{2}',
        'GR' => '[1-9]{1}[0-9]{4}',
        'HR' => '[0-9]{5}',
        'HU' => '\\d{4}',
        'IE' => '(D6W|[A-Z]{1}[0-9]{2})\\s[A-Z]{1}[A-Z0-9]{3}',
        'IT' => '\\d{5}',
        'LT' => '\\d{5}',
        'LU' => '[0-9]\\d{3}',
        'LV' => '(LV-)?[1-9]{1}\\d{3}',
        'MC' => '98[0-9]{3}',
        'MT' => '[A-Z]{3}\\s[0-9]{4}',
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
        // No need zip code countries
        if (in_array($countryCode, [
            'AE',
            'AU',
            'BA',
            'CO',
            'QA',
        ])) {
            return true;
        }
        $regex = '/^' . (static::FORMATS[$countryCode] ?? static::FORMATS['DEFAULT']) . '$/i';

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
