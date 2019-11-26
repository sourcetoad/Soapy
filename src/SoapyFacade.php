<?php
declare(strict_types = 1);

namespace Sourcetoad\Soapy;

use Illuminate\Support\Facades\Facade;

/**
 * Class SoapyFacade
 * @method static SoapyClient create(\Closure $closure = null)
 */
class SoapyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SoapyTub::class;
    }
}
