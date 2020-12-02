<?php

namespace CrazyFactory\Validation;

class LatinCharValidator
{
    public static function isValid(string $txt): bool
    {
        return empty($txt) || preg_match('/^[\p{Latin}\p{Common}]+$/u', $txt) > 0;
    }
}
