<?php

namespace CrazyFactory\Validation\Tests\unit;

use Codeception\Util\Stub;
use CrazyFactory\Validation\Eori\EoriValidator;

class EoriValidatorTest extends \Codeception\Test\Unit
{
    public function testValidate()
    {
        $response = new \stdClass();
        $response->result = new \stdClass();

        // Success
        $response->result->status = 0;
        $soapClient = Stub::makeEmpty(\SoapClient::class, [
            '__soapCall' => $response
        ]);
        $validator = new EoriValidator($soapClient);
        $result = $validator->validate('1234');
        $this->assertTrue($result);


        // Failed
        $response->result->status = 1;
        $soapClient = Stub::makeEmpty(\SoapClient::class, [
            '__soapCall' => $response
        ]);
        $validator = new EoriValidator($soapClient);
        $result = $validator->validate('1234');
        $this->assertFalse($result);
    }

    public function testValidateWithWSDLFaultCode()
    {
        $response = new \stdClass();
        $response->result = new \stdClass();
        // Failed
        $response->result->status = 1;
        $soapClient = Stub::makeEmpty(\SoapClient::class, [
            '__soapCall' => function () {
                throw new \SoapFault('WSDL', 'wsdl error');
            }
        ]);
        $validator = new EoriValidator($soapClient);
        $result = $validator->validate('x');
        $this->assertFalse($result);
    }

    public function testValidateWithByPassRemoteError()
    {
        $response = new \stdClass();
        $response->result = new \stdClass();
        // Failed
        $response->result->status = 1;
        $soapClient = Stub::makeEmpty(\SoapClient::class, [
            '__soapCall' => function () {
                throw new \SoapFault('soap:Server', 'remote server error');
            }
        ]);
        $validator = new EoriValidator($soapClient);
        $validator->setByPassRemoteError(true);
        $result = $validator->validate('x');
        $this->assertTrue($result);
    }

    public function testValidateWithBNotByPassRemoteError()
    {
        $response = new \stdClass();
        $response->result = new \stdClass();
        // Failed
        $response->result->status = 1;
        $soapClient = Stub::makeEmpty(\SoapClient::class, [
            '__soapCall' => function () {
                throw new \SoapFault('soap:Server', 'remote server error');
            }
        ]);
        $validator = new EoriValidator($soapClient);
        $validator->setByPassRemoteError(false);
        $this->expectException(\SoapFault::class);
        $validator->validate('x');
    }
}
