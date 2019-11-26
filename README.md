## Soapy

SOAP is old, but still used. Soapy is modern, but feature limited to fit our use cases.  
Heavily inspired by [artisaninweb/laravel-soap](https://github.com/artisaninweb/laravel-soap).

### Install
This package is currently supporting Laravel 6.x.

```
composer require sourcetoad/soapy
```

This package will use Laravel Auto Discovery to automatically register the Service Provider.

### Documentation

### Options

 * **wsdl** - Location to flat file or URL for WSDL.
 * **trace** - Whether to expose internal methods on SoapClient.
 * **cache** - Flag to use for WSDL cache.
 * **location** - Override URL to use for SOAP Requests.
 * **certificate** - Certificate path for authentication with Server.
 * **options** - Array of any settings from [SoapClient#options](https://www.php.net/manual/en/soapclient.soapclient.php#options)
 * **classmap** - Array of class maps to map objects -> classes.
 * **typemap** - Array of type maps. (Documentation WIP)

#### Example (Class maps)
Creating a client and making a request with class maps.

```
$this->client = SoapyFacade::create(function (SoapyCurtain $curtain) {
    return $curtain
        ->setWsdl('http://example.org?wsdl')
        ->setTrace(true)
        ->setOptions([
            'encoding' => 'UTF-8'
        ])
        ->setClassMap([
            'Foo' => Foo::class,
            'FooResponse' => FooResponse::class
        ])
        ->setCache(WSDL_CACHE_MEMORY)
        ->setLocation(https://example.org);
});
```

Presuming you had XML for the expected request like this.

```
<Foo>
    <bar>Connor</bar>
    <baz>true</baz>
</Foo>
```

You could produce a matching class to resemble that data.

```
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

```
$this->client->call('fizz', new Foo("Connor", true));
```

This shows the benefit of never messing with XML directly.

Likewise for the response. Imagine you got back this.

```
<FooResponse>
    <status>Success.</status>
</FooResponse>
```

This can also be mapped with the following class.

```
<?php
class FooResponse {
    protected $status;
}
```

So now you can do:

```
echo $this->client->call('fizz', new Foo("Connor", true))->status;
// Success.
```


#### Example (No Class maps)

This example shows bare minimum WSDL location and no class maps.

```
$this->client = SoapyFacade::create(function (SoapyCurtain $curtain) {
    return $curtain
        ->setWsdl('http://example.org?wsdl')
});
```

Presuming you had XML for the expected request like this.

```
<Foo>
    <bar>Connor</bar>
    <baz>true</baz>
<Foo>
```

You could then call a fictitious method name "fizz" on the SOAP Class like.

```
$this->client->call('fizz', [
    'bar' => 'Connor',
    'baz' => true
});
```

This is more error prone due to human error with keys, but less work.
