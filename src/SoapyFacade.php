<?php

declare(strict_types=1);

namespace Sourcetoad\Soapy;

use Illuminate\Support\Facades\Facade;

/**
 * Class SoapyFacade
 *
 * @method static SoapyBaseClient create(\Closure $closure = null, string $client = null)
 */
class SoapyFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SoapyTub::class;
    }
}
