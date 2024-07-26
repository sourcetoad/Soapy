<?php

declare(strict_types=1);

namespace Sourcetoad\Soapy\Exceptions;

class ClientClassNotFoundException extends \Exception
{
    protected $message = 'Client class passed does not exist. Ensure fully qualified path is used.';
}
