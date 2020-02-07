<?php

namespace CrazyFactory\Validation\Tests;

use CrazyFactory\Validation\Cpf\CpfValidator;

class CpfValidatorTest extends \Codeception\Test\Unit
{
    public function testIsValid()
    {
        $this->assertTrue(CpfValidator::isValid('123.456.789-12'));
        $this->assertFalse(CpfValidator::isValid('0.123.456.789-12'));
        $this->assertFalse(CpfValidator::isValid('123.456.789-123'));
        $this->assertFalse(CpfValidator::isValid('abc'));
        $this->assertFalse(CpfValidator::isValid('123'));
    }
}
