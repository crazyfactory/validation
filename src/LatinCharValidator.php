<?php

namespace CrazyFactory\Validation;

class LatinCharValidator
{
    public static function isValid(string $txt): bool
    {
        return empty($txt) || (preg_match('/^[\p{Latin}\p{Common}]+$/u', $txt) > 0 && preg_match('/[^\w\x{0080}-\x{FFFF}]+$/u', $txt) == 0 );
    }
}
