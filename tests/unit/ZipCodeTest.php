<?php

namespace CrazyFactory\Validation\Tests;

use CrazyFactory\Validation\ZipCode\Sanitizer;
use CrazyFactory\Validation\ZipCode\Validator;

class ZipCodeTest extends \Codeception\Test\Unit
{
    public function testIsValid()
    {
        $this->assertFalse(Validator::isValid('', 'AT'), 'empty');
        $this->assertFalse(Validator::isValid('A', 'DE'), 'DE: A');
        $this->assertFalse(Validator::isValid('01234', 'LU'), 'LU');
        $this->assertFalse(Validator::isValid('01234', 'RO'), 'RO');
        $this->assertFalse(Validator::isValid('20207 MLINI', 'HR'), 'HR');
        $this->assertTrue(Validator::isValid('123456', 'RO'), 'RO');
        $this->assertTrue(Validator::isValid('01234', 'FR'), 'FR');
        $this->assertTrue(Validator::isValid('M6 6SD', 'GB'), 'GB: M6 6SD');
        $this->assertTrue(Validator::isValid('11111', 'HR'), 'HR: 11111');
        $this->assertTrue(Validator::isValid('0363', 'LU'), 'LU');

        $noPostCodeCountries = ['AE', 'AU', 'BA', 'CO', 'QA'];
        foreach ($noPostCodeCountries as $country) {
            $this->assertTrue(Validator::isValid('', $country));
            $this->assertTrue(Validator::isValid('00000', $country));
            $this->assertTrue(Validator::isValid('N/A', $country));
        }
    }

    public function testSanitize()
    {
        $this->assertSame('', Sanitizer::sanitize('', 'GB'), 'empty');
        $this->assertSame('M6 6SD', Sanitizer::sanitize('M6 6 sd', 'GB'), 'GB');
        $this->assertSame('M61 6SD', Sanitizer::sanitize('M6 16 sD', 'GB'), 'GB');
        $this->assertSame('M621 6SD', Sanitizer::sanitize('M62 16 Sd', 'GB'), 'GB');
        $this->assertSame('12345', Sanitizer::sanitize('1 23 45', 'FR'), 'FR');
        $this->assertSame('12345', Sanitizer::sanitize('1 23 45', 'FR'), 'FR');
        $this->assertSame('1234 XY', Sanitizer::sanitize('1234XY', 'NL'), 'NL');
        $this->assertSame('123 45', Sanitizer::sanitize('12345', 'CZ'), 'CZ');
        $this->assertSame('123 45', Sanitizer::sanitize('1 234 5', 'CZ', $sanitized), 'CZ');
        $this->assertTrue($sanitized);
        $this->assertSame('CantFix', Sanitizer::sanitize('CantFix', 'FI', $sanitized), 'cant fix');
        $this->assertFalse($sanitized);
    }

    public function testExamples()
    {
        foreach (Validator::EXAMPLES as $country => $codes) {
            foreach ($codes as $code) {
                $this->assertTrue(Validator::isValid($code, $country), "{$code} is in valid for {$country}");
            }
        }
    }
}
