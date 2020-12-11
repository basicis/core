# Basicis\Http\Message\ServerRequestFactory  

ServerRequestFactory class

## Implements:
Psr\Http\Message\ServerRequestFactoryInterface



## Methods

| Name | Description |
|------|-------------|
|[create](#serverrequestfactorycreate)|Function create
Create a new server request.|
|[createServerRequest](#serverrequestfactorycreateserverrequest)|Function createServerRequest
Create a new server request.|




### ServerRequestFactory::create  

**Description**

```php
public static create (string $method, \UriInterface|string $uri, array $serverParams)
```

Function create
Create a new server request. 

Note that server-params are taken precisely as given - no parsing/processing  
of the given values is performed, and, in particular, no attempt is made to  
determine the HTTP method or URI, which must be provided explicitly. 

**Parameters**

* `(string) $method`
: The HTTP method associated with the request.  
* `(\UriInterface|string) $uri`
: The URI associated with the request. If  
the value is a string, the factory MUST create a UriInterface  
instance based on it.  
* `(array) $serverParams`
: Array of SAPI parameters with which to seed  
the generated request instance.  

**Return Values**

`\ServerRequestInterface`




<hr />


### ServerRequestFactory::createServerRequest  

**Description**

```php
public createServerRequest (string $method, \UriInterface|string $uri, array $serverParams)
```

Function createServerRequest
Create a new server request. 

Note that server-params are taken precisely as given - no parsing/processing  
of the given values is performed, and, in particular, no attempt is made to  
determine the HTTP method or URI, which must be provided explicitly. 

**Parameters**

* `(string) $method`
: The HTTP method associated with the request.  
* `(\UriInterface|string) $uri`
: The URI associated with the request. If  
the value is a string, the factory MUST create a UriInterface  
instance based on it.  
* `(array) $serverParams`
: Array of SAPI parameters with which to seed  
the generated request instance.  

**Return Values**

`\ServerRequestInterface`




<hr />

