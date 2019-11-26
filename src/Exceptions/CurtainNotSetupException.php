<?php
declare(strict_types = 1);

namespace Sourcetoad\Soapy\Exceptions;

class CurtainNotSetupException extends \Exception
{
    protected $message = 'Curtain was empty. Ensure you are returning the service from the closure!';
}
