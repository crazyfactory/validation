<?php

namespace CrazyFactory\Validation\Tests\unit;


use CrazyFactory\Validation\Eori\EoriValidator;

class EoriValidatorTest extends \Codeception\Test\Unit
{
    public function dataTestValidate()
    {
        return [
            ['eori' => 'DE12354', 'expected' => true],
            ['eori' => 'DE1', 'expected' => true],
            ['eori' => 'DE', 'expected' => false],
            ['eori' => 'TH1234', 'expected' => false],
            ['eori' => 'DE11111111111111111111', 'expected' => false],
            ['eori' => 'DEEE1111', 'expected' => false]
        ];
    }

    /**
     * @dataProvider dataTestValidate
     * @param $eori
     * @param $expected
     * @throws \Exception
     */
    public function testValidate($eori, $expected)
    {
        $result = (new EoriValidator)->validate($eori);
        $this->assertSame($result, $expected);
    }
}
