<?php
declare(strict_types = 1);

namespace Sourcetoad\Soapy;

use Sourcetoad\Soapy\Exceptions\ClientClassNotFoundException;
use Sourcetoad\Soapy\Exceptions\CurtainNotSetupException;
use Sourcetoad\Soapy\Exceptions\CurtainRequiresWsdlException;

class SoapyTub
{
    public function create(\Closure $closure, string $soapClient = null): SoapyBaseClient
    {
        $curtain = new SoapyCurtain();

        /** @var SoapyCurtain $service */
        $service = $closure($curtain);

        if (is_null($service)) {
            throw new CurtainNotSetupException();
        }

        /** @var SoapyBaseClient $soapyClient */
        $soapyClient = SoapyClient::class;
        if (! empty($soapClient)) {
            if (! class_exists($soapClient)) {
                throw new ClientClassNotFoundException();
            }
            $soapyClient = $soapClient;
        }

        if (empty($service->getWsdl())) {
            throw new CurtainRequiresWsdlException();
        }

        $client = new $soapyClient(
            $service->getWsdl(),
            $service->getOptions()
        );

        return $client;
    }
}
