<?php

namespace CrazyFactory\Validation\Eori;

use SoapClient;

class EoriValidator
{
    private $soapClient;
    // Interpret the result as valid if match these fault codes
    private $ignoreFaultCodes = [];
    // Interpret the result as invalid if match these fault codes
    private $negativeFaultCodes = [];

    // Exception will be thrown if fault code match none of the above settings

    public function __construct(SoapClient $client = null)
    {
        $this->soapClient = $client ?? new SoapClient('https://ec.europa.eu/taxation_customs/dds2/eos/validation/services/validation?wsdl');
        $this->negativeFaultCodes = ['soap:Server'];
        $this->ignoreFaultCodes = ['WSDL'];
    }

    public function setNegativeFaultCodes(array $negativeFaultCodes): EoriValidator
    {
        $this->negativeFaultCodes = $negativeFaultCodes;

        return $this;
    }

    public function setIgnoreFaultCodes(array $faultCodes): EoriValidator
    {
        $this->ignoreFaultCodes = $faultCodes;

        return $this;
    }

    /**
     * @param string $eori
     * @return bool
     * @throws \SoapFault
     */
    public function validate(string $eori): bool
    {
        try {
            $response = $this->soapClient->__soapCall('validateEORI', ['validateEORI' => ['eori' => $eori]]);

            // 0 = success
            // 1 = failed

            return $response->result->status === 0;
        }
        catch (\SoapFault $e) {
            if (in_array($e->faultcode, $this->negativeFaultCodes)) {
                return false;
            }

            if (in_array($e->faultcode, $this->ignoreFaultCodes)) {
                return true;
            }

            throw $e;
        }
    }
}
