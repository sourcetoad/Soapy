<?php
declare(strict_types = 1);

namespace Sourcetoad\Soapy;

abstract class SoapyBaseClient extends \SoapClient
{
    public function call($function, $arguments)
    {
        return $this->$function($arguments);
    }
}
