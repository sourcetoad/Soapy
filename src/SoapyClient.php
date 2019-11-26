<?php
declare(strict_types = 1);

namespace Sourcetoad\Soapy;

class SoapyClient extends \SoapClient
{
    public function __construct($wsdl, array $options = null)
    {
        parent::__construct($wsdl, $options);
    }

    public function call($function, $arguments)
    {
        return call_user_func_array([$this, $function], $arguments);
    }
}
