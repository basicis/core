# Basicis\Http\Server\RequestHandler  

RequestHandler class
Handles a server request and produces a response.

An HTTP request handler process an HTTP request in order to produce an
HTTP response.  

## Implements:
Psr\Http\Server\RequestHandlerInterface



## Methods

| Name | Description |
|------|-------------|
|[__construct](#requesthandler__construct)|Function __construct
Receives a instance of Basicis\Basicis $app as argument|
|[handle](#requesthandlerhandle)|Function handle
Handles a request and produces a response.|




### RequestHandler::__construct  

**Description**

```php
public __construct (\Basicis\Basicis $app)
```

Function __construct
Receives a instance of Basicis\Basicis $app as argument 

 

**Parameters**

* `(\Basicis\Basicis) $app`

**Return Values**

`void`


<hr />


### RequestHandler::handle  

**Description**

```php
public handle (\Psr\Http\Message\ServerRequestInterface $request)
```

Function handle
Handles a request and produces a response. 

May call other collaborating code to generate the response. 

**Parameters**

* `(\Psr\Http\Message\ServerRequestInterface) $request`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />

