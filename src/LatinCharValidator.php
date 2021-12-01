<?php

namespace CrazyFactory\Validation;

class LatinCharValidator
{
    /**
     * exclude C0 controls (basic latin): https://unicode-table.com/en/blocks/basic-latin/
     * @param  string  $txt
     *
     * @return bool
     */
    public static function isValid(string $txt): bool
    {
        return empty($txt) || (preg_match('/^[\p{Latin}\p{Common}]+$/u', $txt) > 0 && preg_match('/[\x{0000}-\x{001F}]/u', $txt) == 0 );
    }
}
