<?php

namespace CrazyFactory\Validation\ZipCode;

class Sanitizer
{
    /**
     * Sanitize/format a zip code so it is valid for given country.
     *
     * In the worst case it will return the original input as it is.
     *
     * @param  string $zipCode      The zip code.
     * @param  string $countryCode  The country ISO2 code.
     * @param  bool   $sanitized    Indicates if the operation has been successful.
     *
     * @return string
     */
    public function format(string $zipCode, string $countryCode, bool &$sanitized = null): string
    {
        $newCode = strtoupper($zipCode);

        if ($sanitized = Validator::isValid($newCode, $countryCode)) {
            return $newCode;
        }

        $splitPos = 0;
        $newCode  = str_replace(' ', '', $newCode);

        if ($countryCode === 'NL') {
            $splitPos = 4;
        }
        elseif ($countryCode === 'GB') {
            $splitPos = min(max(strlen($newCode) - 3, 2), 4);
        }
        elseif (in_array($countryCode, ['CZ', 'MT', 'SE', 'SK'])) {
            $splitPos = 3;
        }

        if ($splitPos > 0) {
            $newCode = trim(substr($newCode, 0, $splitPos)) . ' ' . trim(substr($newCode, $splitPos));
        }

        if ($sanitized = Validator::isValid($newCode, $countryCode)) {
            return $newCode;
        }

        // Fallback to original code.
        return $zipCode;
    }

    /**
     * Sanitize/format a zip code so it is valid for given country.
     *
     * Static alias of format().
     *
     * @param  string $zipCode      The zip code.
     * @param  string $countryCode  The country ISO2 code.
     * @param  bool   $sanitized    Indicates if the operation has been successful.
     *
     * @return string
     */
    public static function sanitize(string $zipCode, string $countryCode, bool &$sanitized = null): string
    {
        static $instance;

        if (!$instance) {
            $instance = new static;
        }

        return $instance->format($zipCode, $countryCode, $sanitized);
    }
}
