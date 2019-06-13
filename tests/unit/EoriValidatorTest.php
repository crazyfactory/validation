<?php

namespace CrazyFactory\Validation\Tests\unit;

use Codeception\Util\Stub;
use CrazyFactory\Validation\Eori\EoriValidator;

class EoriValidatorTest extends \Codeception\Test\Unit
{
    /**
     * @param $eori
     * @param $expected
     * @throws \Exception
     */
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
}
