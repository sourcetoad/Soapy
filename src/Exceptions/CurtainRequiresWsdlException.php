<?php

declare(strict_types=1);

namespace Sourcetoad\Soapy\Exceptions;

class CurtainRequiresWsdlException extends \Exception
{
    protected $message = 'Curtain requires calling setWsdl() or setLocation/setUri in order to populate class.';
}
