<?php

namespace CrazyFactory\Validation\Cpf;

class CpfValidator
{
    public static function isValid(string $cpf): bool
    {
        return preg_match('/^[0-9][0-9][0-9]\.[0-9][0-9][0-9]\.[0-9][0-9][0-9]-[0-9][0-9]$/', $cpf) > 0;
    }
}
