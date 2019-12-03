<?php
declare(strict_types = 1);

namespace Sourcetoad\Soapy\Exceptions;

class CurtainRequiresWsdlException extends \Exception
{
    protected $message = 'Curtain requires calling getWsdl() in order to populate class.';
}
