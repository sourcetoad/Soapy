<?php

declare(strict_types=1);

namespace Sourcetoad\Soapy;

class SoapyCurtain
{
    protected ?string $wsdl = null;

    protected bool $trace = false;

    protected int $cache = WSDL_CACHE_NONE;

    protected ?string $location = null;

    protected ?string $uri = null;

    protected ?string $certificate = null;

    protected array $options = [];

    protected array $classMap = [];

    protected array $typeMap = [];

    // region getters

    public function getWsdl(): ?string
    {
        return $this->wsdl;
    }

    public function getTrace(): bool
    {
        return $this->trace;
    }

    public function getCache(): int
    {
        return $this->cache;
    }

    public function getCertificate(): ?string
    {
        return $this->certificate;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function getOptions(): array
    {
        $baseOptions = [
            'trace' => $this->getTrace(),
            'cache_wsdl' => $this->getCache(),
        ];

        if ($this->getClassmap()) {
            $baseOptions['classmap'] = $this->getClassmap();
        }

        if ($this->getTypemap()) {
            $baseOptions['typemap'] = $this->getTypemap();
        }

        if ($this->getCertificate()) {
            $baseOptions['local_cert'] = $this->getCertificate();
        }

        if ($this->getLocation()) {
            $baseOptions['location'] = $this->getLocation();
        }

        if ($this->getUri()) {
            $baseOptions['uri'] = $this->getUri();
        }

        return array_merge($this->options, $baseOptions);
    }

    public function getClassmap(): ?array
    {
        return $this->classMap;
    }

    public function getTypemap(): ?array
    {
        return $this->typeMap;
    }

    // endregion

    // region setters

    public function setWsdl(string $wsdl): self
    {
        $this->wsdl = $wsdl;

        return $this;
    }

    public function setTrace(bool $flag): self
    {
        $this->trace = $flag;

        return $this;
    }

    public function setCache(int $cache): self
    {
        $allowed = [WSDL_CACHE_NONE, WSDL_CACHE_DISK, WSDL_CACHE_MEMORY, WSDL_CACHE_BOTH];

        if (! in_array($cache, $allowed)) {
            throw new \InvalidArgumentException('Cache value passed ('.$cache.') is not valid.');
        }

        $this->cache = $cache;

        return $this;
    }

    public function setClassMap(array $classmap): self
    {
        $classes = [];
        foreach ($classmap as $key => $class) {
            if (is_numeric($key)) {
                $key = (new \ReflectionClass($class))->getShortName();
            }
            $classes[$key] = $class;
        }

        $this->classMap = $classes;

        return $this;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function setCertificate(string $certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    public function addTypeMapViaClassName(string $namespace, string $item, string $itemClass): self
    {
        $function = function (string $xml) use ($itemClass) {
            $object = simplexml_load_string($xml);

            return new $itemClass($object);
        };

        return $this->addTypeMap($namespace, $item, $function);
    }

    public function addTypeMap(string $namespace, string $item, \Closure $fromXml): self
    {
        $typeMap = [
            'type_ns' => $namespace,
            'type_name' => $item,
            'from_xml' => $fromXml,
        ];

        $this->typeMap[] = $typeMap;

        return $this;
    }

    // endregion

    // region functions

    public function isReady(): bool
    {
        if (! empty($this->getLocation()) && ! empty($this->getUri())) {
            return true;
        }

        return ! empty($this->getWsdl());
    }

    // endregion
}
