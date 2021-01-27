# Basicis\Http\Server\RequestHandler  

RequestHandler class
Handles a server request and produces a response.

An HTTP request handler process an HTTP request in order to produce an
HTTP response.  

## Implements:
Basicis\Http\Server\RequestHandlerInterface



## Methods

| Name | Description |
|------|-------------|
|[__invoke](#requesthandler__invoke)|Function handle
Handles a request and produces a response.|
|[handle](#requesthandlerhandle)|Function handle
Handles a request and produces a response.|




### RequestHandler::__invoke  

**Description**

```php
public __invoke (\ServerRequestInterface $request, \ResponseInterface $response, callable $next)
```

Function handle
Handles a request and produces a response. 

May call other collaborating code to generate the response. 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(\ResponseInterface) $response`
* `(callable) $next`
: null  

**Return Values**

`\ResponseInterface`




<hr />


### RequestHandler::handle  

**Description**

```php
public handle (\ServerRequestInterface $request, \ResponseInterface $response, callable $next)
```

Function handle
Handles a request and produces a response. 

May call other collaborating code to generate the response. 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(\ResponseInterface) $response`
* `(callable) $next`
: null  

**Return Values**

`\ResponseInterface`




<hr />

