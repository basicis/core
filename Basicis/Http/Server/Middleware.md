# Basicis\Http\Server\Middleware  

Middleware class
Participant in processing a server request and response.

An HTTP middleware component participates in processing an HTTP message:
by acting on the request, generating the response, or forwarding the
request to a subsequent middleware and possibly acting on its response.  

## Implements:
Psr\Http\Server\RequestHandlerInterface, Psr\Http\Server\MiddlewareInterface

## Extend:

Basicis\Http\Server\RequestHandler

## Methods

| Name | Description |
|------|-------------|
|[__construct](#middleware__construct)|Function __construct
Receives an instance of Basicis \ Basicis or null as param|
|[process](#middlewareprocess)|Function process
Process an incoming server request.|

## Inherited methods

| Name | Description |
|------|-------------|
|handle|Function handle
Handles a request and produces a response.|



### Middleware::__construct  

**Description**

```php
public __construct (\Basicis\Basicis $app)
```

Function __construct
Receives an instance of Basicis \ Basicis or null as param 

 

**Parameters**

* `(\Basicis\Basicis) $app`

**Return Values**

`void`


<hr />


### Middleware::process  

**Description**

```php
public process (void)
```

Function process
Process an incoming server request. 

Processes an incoming server request in order to produce a response.  
If unable to produce the response itself, it may delegate to the provided  
request handler to do so. 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />

