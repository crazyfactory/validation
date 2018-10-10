<?php

namespace CrazyFactory\Validation\Tests;

class ZipCodeTest extends \Codeception\Test\Unit
{
    public function testIsValid()
    {
        $this->assertFalse(ZipCodeValidator::isValid('', 'AT'), 'empty');
        $this->assertFalse(ZipCodeValidator::isValid('A', 'DE'), 'DE: A');
        $this->assertFalse(ZipCodeValidator::isValid('01234', 'LU'), 'LU');
        $this->assertFalse(ZipCodeValidator::isValid('01234', 'RO'), 'RO');
        $this->assertTrue(ZipCodeValidator::isValid('123456', 'RO'), 'RO');
        $this->assertTrue(ZipCodeValidator::isValid('01234', 'FR'), 'FR');
        $this->assertTrue(ZipCodeValidator::isValid('M6 6SD', 'GB'), 'GB: M6 6SD');
    }

    public function testSanitize()
    {
        $this->assertSame('', ZipCodeSanitizer::sanitize('', 'GB'), 'empty');
        $this->assertSame('M6 6SD', ZipCodeSanitizer::sanitize('M6 6 sd', 'GB'), 'GB');
        $this->assertSame('M61 6SD', ZipCodeSanitizer::sanitize('M6 16 sD', 'GB'), 'GB');
        $this->assertSame('M621 6SD', ZipCodeSanitizer::sanitize('M62 16 Sd', 'GB'), 'GB');
        $this->assertSame('12345', ZipCodeSanitizer::sanitize('1 23 45', 'FR'), 'FR');
        $this->assertSame('12345', ZipCodeSanitizer::sanitize('1 23 45', 'FR'), 'FR');
        $this->assertSame('1234 XY', ZipCodeSanitizer::sanitize('1234XY', 'NL'), 'NL');
        $this->assertSame('123 45', ZipCodeSanitizer::sanitize('12345', 'CZ'), 'CZ');
        $this->assertSame('123 45', ZipCodeSanitizer::sanitize('1 234 5', 'CZ'), 'CZ');
        $this->assertSame('CantFix', ZipCodeSanitizer::sanitize('CantFix', 'FI'), 'cant fix');
    }
}
