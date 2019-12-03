<?php
declare(strict_types = 1);

namespace Sourcetoad\Soapy\Tests;

use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
{
    protected $baseWsdl;

    public function setUp(): void
    {
        parent::setUp();
        $this->baseWsdl = __DIR__ . '/example.wsdl';
    }
}
