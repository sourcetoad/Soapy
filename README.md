## Soapy

SOAP is old, but still used. Soapy is modern, but feature limited to fit our use cases.  
Heavily inspired by [artisaninweb/laravel-soap](https://github.com/artisaninweb/laravel-soap).

### Install
This package is currently supporting Laravel 11.x and 12.x.

```shell
composer require sourcetoad/soapy
```

This package will use Laravel Auto Discovery to automatically register the Service Provider.

### Documentation

### Options

 * **wsdl** - Location to flat file or URL for WSDL.
 * **trace** - Whether to expose internal methods on SoapClient.
 * **cache** - Flag to use for WSDL cache.
 * **location** - Override URL to use for SOAP Requests.
 * **uri** - Override namespace to use for SOAP Requests.
 * **certificate** - Certificate path for authentication with Server.
 * **options** - Array of any settings from [SoapClient#options](https://www.php.net/manual/en/soapclient.soapclient.php#options)
 * **classmap** - Array of class maps to map objects -> classes.
 * **typemap** - Array of type maps. (Documentation WIP)

#### Example (Class maps)
Creating a client and making a request with class maps.

```php
$this->client = SoapyFacade::create(function (SoapyCurtain $curtain) {
    return $curtain
        ->setWsdl('https://example.org?wsdl')
        ->setTrace(true)
        ->setOptions([
            'encoding' => 'UTF-8'
        ])
        ->setClassMap([
            'Foo' => Foo::class,
            'FooResponse' => FooResponse::class
        ])
        ->setCache(WSDL_CACHE_MEMORY)
        ->setLocation('https://example.org');
});
```

Presuming you had XML for the expected request like this.

```xml
<Foo>
    <bar>Connor</bar>
    <baz>true</baz>
</Foo>
```

You could produce a matching class to resemble that data.

```php
<?php
class Foo {
    protected $bar;
    protected $baz;
    
    public function __construct(string $bar, bool $baz) {
        $this->bar = $bar;
        $this->baz = $baz;
    }
}
```

You could then call a fictitious method name "fizz" on the SOAP Class like.

```php
$this->client->call('fizz', new Foo("Connor", true));
```

This shows the benefit of never messing with XML directly.

Likewise for the response. Imagine you got back this.

```xml
<FooResponse>
    <status>Success.</status>
</FooResponse>
```

This can also be mapped with the following class.

```php
<?php
class FooResponse {
    protected $status;
}
```

So now you can do:

```php
echo $this->client->call('fizz', new Foo("Connor", true))->status;
// Success.
```


#### Example (No Class maps)

This example shows bare minimum WSDL location and no class maps.

```php
$this->client = SoapyFacade::create(function (SoapyCurtain $curtain) {
    return $curtain
        ->setWsdl('https://example.org?wsdl')
});
```

Presuming you had XML for the expected request like this.

```xml
<Foo>
    <bar>Connor</bar>
    <baz>true</baz>
</Foo>
```

You could then call a fictitious method name "fizz" on the SOAP Class like.

```php
$this->client->call('fizz', [
    'bar' => 'Connor',
    'baz' => true
});
```

This is more error prone due to human error with keys, but less work.

#### Example (Custom Client)

Sometimes you may have a SOAP Integration that just isn't fun. It may use something that our default SoapyClient cannot handle.
This is okay, because patching a generic SOAP Client for all the strangeness that can happen is not feasible.

Start with a new class, that extends our SoapyBaseClient.

```php
<?php
class CustomClass extends \Sourcetoad\Soapy\SoapyBaseClient {
    //
}
```

From that class. You can overload any of the functions it provides.

Then pass the class name (fully qualified) to the Curtain during generation.

```php
$this->client = SoapyFacade::create(function (SoapyCurtain $curtain) {
    return $curtain
        ->setWsdl('https://example.org?wsdl')
}, CustomClass::class);
```
