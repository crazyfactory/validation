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
        $this->assertTrue(Validator::isValid('123456', 'RO'), 'RO');
        $this->assertTrue(Validator::isValid('01234', 'FR'), 'FR');
        $this->assertTrue(Validator::isValid('M6 6SD', 'GB'), 'GB: M6 6SD');
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
}
