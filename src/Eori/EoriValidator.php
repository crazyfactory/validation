<?php

namespace CrazyFactory\Validation\Eori;

use CrazyFactory\HarmonizedSystem\Countries;

class EoriValidator
{
    /**
     * @param string $eori
     * @return bool
     */
    public function validate(string $eori): bool
    {
        $countryCode = substr($eori, 0, 2);
        if (!Countries::isEU($countryCode) || strlen($eori) > 17 || strlen($eori) <= 2) {
            return false;
        }

        return true;
    }
}
