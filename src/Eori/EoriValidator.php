<?php

namespace CrazyFactory\Validation\Eori;

use SoapClient;

class EoriValidator
{
    private $soapClient;
    private $byPassRemoteError = true;

    public function __construct(SoapClient $client = null)
    {
        $this->soapClient = $client ?? new SoapClient('https://ec.europa.eu/taxation_customs/dds2/eos/validation/services/validation?wsdl');
    }

    public function setByPassRemoteError(bool $byPassRemoteError): EoriValidator
    {
        $this->byPassRemoteError = $byPassRemoteError;

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
        } catch (\SoapFault $e) {
            if ($e->faultcode === 'WSDL') {
                return false;
            }

            if ($this->byPassRemoteError) {
                return true;
            }

            throw $e;
        }
    }
}
