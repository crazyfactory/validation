<?php

namespace CrazyFactory\Validation\Eori;

use SoapClient;

class EoriValidator
{
    /**
     * @var SoapClient
     */
    private $soapClient;

    /**
     * Interpret the result as valid if match these fault codes
     * @var array
     */
    private $ignoreFaultCodes = [];

    /**
     * Interpret the result as invalid if match these fault codes
     * @var array
     */
    private $negativeFaultCodes = [];

    public function __construct(SoapClient $client = null)
    {
        $this->soapClient = $client;
        $this->negativeFaultCodes = ['soap:Server'];
        $this->ignoreFaultCodes = ['WSDL'];
    }

    /**
     * @param array $negativeFaultCodes
     * @return EoriValidator
     */
    public function setNegativeFaultCodes(array $negativeFaultCodes): EoriValidator
    {
        $this->negativeFaultCodes = $negativeFaultCodes;

        return $this;
    }

    /**
     * @param array $faultCodes
     * @return EoriValidator
     */
    public function setIgnoreFaultCodes(array $faultCodes): EoriValidator
    {
        $this->ignoreFaultCodes = $faultCodes;

        return $this;
    }

    /**
     * Validate EORI against SOAP API.
     * You can define $negativeFaultCodes and $ignoreFaultCodes to control the output that make sense for your application.
     * If the fault code does not match any of those two settings, then exception will be thrown.
     *
     * @param string $eori
     * @return bool
     * @throws \SoapFault
     */
    public function validate(string $eori): bool
    {
        try {
            if (preg_match('/[A-Z]{2}[^\s\n\r\t]*/', $eori) !== 1) {
                return false;
            }

            if (empty($this->soapClient)) {
                $this->soapClient = new SoapClient('https://ec.europa.eu/taxation_customs/dds2/eos/validation/services/validation?wsdl');
            }

            $response = $this->soapClient->__soapCall('validateEORI', ['validateEORI' => ['eori' => $eori]]);

            // 0 = success
            // 1 = failed

            return $response->return->result->status === 0;
        } catch (\SoapFault $e) {
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
