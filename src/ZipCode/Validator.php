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
        // 'IE' See above
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
        // 'IE' => '[-1-9]{1}', See above
        'IT' => '\\d{5}',
        'LT' => '\\d{5}',
        'LU' => '[0-9]\\d{3}',
        'LV' => '(LV-)?[1-9]{1}\\d{3}',
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
        // See above
        if ($countryCode === 'IE') {
            return true;
        }

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
        // See above
        if ($countryCode === 'IE') {
            return true;
        }

        static $instance;

        if (!$instance) {
            $instance = new static;
        }

        return $instance->validate($zipCode, $countryCode);
    }
}
