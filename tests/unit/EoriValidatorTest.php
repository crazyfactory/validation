<?php

namespace CrazyFactory\Validation\Tests\unit;

use CrazyFactory\Validation\Eori\EoriValidator;
use PHPUnit\Framework\TestCase;

class EoriValidatorTest extends TestCase
{
    private function makeSoapClient($returnOrCallable)
    {
        $mock = $this->getMockBuilder(\SoapClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        if (is_callable($returnOrCallable)) {
            $mock->method('__soapCall')->willReturnCallback($returnOrCallable);
        } else {
            $mock->method('__soapCall')->willReturn($returnOrCallable);
        }

        return $mock;
    }

    public function testValidate()
    {
        $response = new \stdClass();
        $response->return = new \stdClass();
        $response->return->result = new \stdClass();

        $response->return->result->status = 0;
        $validator = new EoriValidator($this->makeSoapClient($response));
        $this->assertTrue($validator->validate('IE7761569R'));

        $response->return->result->status = 1;
        $validator = new EoriValidator($this->makeSoapClient($response));
        $this->assertFalse($validator->validate('IE7761569R'));
    }

    public function testValidateWhenWsdlCannotBeLoaded()
    {
        $soapClient = $this->makeSoapClient(function () {
            throw new \SoapFault('WSDL', 'wsdl error');
        });
        $this->assertTrue((new EoriValidator($soapClient))->validate('IE7761569R'));
    }

    public function testValidateWithServerError()
    {
        $soapClient = $this->makeSoapClient(function () {
            throw new \SoapFault('soap:Server', 'remote server error');
        });
        $this->assertFalse((new EoriValidator($soapClient))->validate('IE7761569R'));
    }

    public function testValidateWhenFaultCodeNotMatchAnySetting()
    {
        $soapClient = $this->makeSoapClient(function () {
            throw new \SoapFault('Client', 'remote server error');
        });
        $this->assertFalse((new EoriValidator($soapClient))->validate('IE7761569R'));
    }

    public function testValidateWhenLocalRegexNotMatch()
    {
        $this->assertFalse((new EoriValidator())->validate('x'));
    }
}
