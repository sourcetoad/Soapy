<?php
declare(strict_types = 1);

namespace Sourcetoad\Soapy;

use Sourcetoad\Soapy\Exceptions\CurtainNotSetupException;

class SoapyTub
{
    public function create(\Closure $closure): SoapyClient
    {
        $curtain = new SoapyCurtain();

        /** @var SoapyCurtain $service */
        $service = $closure($curtain);

        if (is_null($service)) {
            throw new CurtainNotSetupException();
        }

        $client = new SoapyClient(
            $service->getWsdl(),
            $service->getOptions()
        );

        return $client;
    }
}
