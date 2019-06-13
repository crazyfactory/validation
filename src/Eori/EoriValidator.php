<?php

namespace CrazyFactory\Validation\Eori;

use SoapClient;

class EoriValidator
{
    private $soapClient;

    public function __construct(SoapClient $client = null)
    {
        $this->soapClient = $client ?? new SoapClient('https://ec.europa.eu/taxation_customs/dds2/eos/validation/services/validation?wsdl');
    }

    /**
     * @param string $eori
     * @return bool
     */
    public function validate(string $eori): bool
    {
        $response = $this->soapClient->__soapCall('validateEORI', ['validateEORI' => ['eori' => $eori]]);

        // 0 = success
        // 1 = failed

        return $response->result->status === 0;
    }
}
