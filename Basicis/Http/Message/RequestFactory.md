# Basicis\Http\Message\RequestFactory  

RequestFactory class

## Implements:
Psr\Http\Message\RequestFactoryInterface



## Methods

| Name | Description |
|------|-------------|
|[create](#requestfactorycreate)|Funtion static createRequest
Create a new request.|
|[createRequest](#requestfactorycreaterequest)|Funtion createRequest
Create a new request.|




### RequestFactory::create  

**Description**

```php
public static create (string $method, \UriInterface|string $uri)
```

Funtion static createRequest
Create a new request. 

 

**Parameters**

* `(string) $method`
: The HTTP method associated with the request.  
* `(\UriInterface|string) $uri`
: The URI associated with the request.  
If the value is a string, the factory MUST create a UriInterface instance based on it.  

**Return Values**

`\RequestInterface`




<hr />


### RequestFactory::createRequest  

**Description**

```php
public createRequest (string $method, \UriInterface|string $uri)
```

Funtion createRequest
Create a new request. 

 

**Parameters**

* `(string) $method`
: The HTTP method associated with the request.  
* `(\UriInterface|string) $uri`
: The URI associated with the request.  
If the value is a string, the factory MUST create a UriInterface instance based on it.  

**Return Values**

`\RequestInterface`




<hr />

