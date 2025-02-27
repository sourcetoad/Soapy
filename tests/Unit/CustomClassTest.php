<?php

declare(strict_types=1);

namespace Sourcetoad\Soapy\Tests\Unit;

use Sourcetoad\Soapy\SoapyBaseClient;
use Sourcetoad\Soapy\SoapyClient;
use Sourcetoad\Soapy\SoapyCurtain;
use Sourcetoad\Soapy\SoapyFacade;
use Sourcetoad\Soapy\Tests\BaseTestCase;
use Sourcetoad\Soapy\Tests\TestSoapyClient;

class CustomClassTest extends BaseTestCase
{
    public function test_creating_client_with_no_custom_overload()
    {
        $client = SoapyFacade::create(function (SoapyCurtain $curtain) {
            return $curtain
                ->setWsdl($this->baseWsdl);
        });

        $this->assertInstanceOf(SoapyClient::class, $client);
        $this->assertInstanceOf(SoapyBaseClient::class, $client);
    }

    public function test_creating_client_with_custom_overload()
    {
        $baseClient = TestSoapyClient::class;

        $client = SoapyFacade::create(function (SoapyCurtain $curtain) {
            return $curtain
                ->setWsdl($this->baseWsdl);
        }, $baseClient);

        $this->assertInstanceOf(TestSoapyClient::class, $client);
        $this->assertInstanceOf(SoapyBaseClient::class, $client);
    }
}
