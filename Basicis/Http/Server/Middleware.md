# Basicis\Http\Server\Middleware  

Middleware class
Participant in processing a server request and response.

An HTTP middleware component participates in processing an HTTP message:
by acting on the request, generating the response, or forwarding the
request to a subsequent middleware and possibly acting on its response.  

## Implements:
Basicis\Http\Server\MiddlewareInterface



## Methods

| Name | Description |
|------|-------------|
|[__invoke](#middleware__invoke)|Function process
Process an incoming server request a alias to process method|
|[pipeLine](#middlewarepipeline)|Funtion setPipeLine
Handle all middlewares|
|[process](#middlewareprocess)|Function process
Process an incoming server request.|




### Middleware::__invoke  

**Description**

```php
public __invoke (\ServerRequestInterface $request, \ResponseInterface $response, \MiddlewareInterface|null $next)
```

Function process
Process an incoming server request a alias to process method 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(\ResponseInterface) $response`
* `(\MiddlewareInterface|null) $next`

**Return Values**

`\ResponseInterface`




<hr />


### Middleware::pipeLine  

**Description**

```php
public static pipeLine (array $middlewares, \ServerRequestInterface $request, \ResponseInterface $response, callable $next)
```

Funtion setPipeLine
Handle all middlewares 

 

**Parameters**

* `(array) $middlewares`
* `(\ServerRequestInterface) $request`
* `(\ResponseInterface) $response`
* `(callable) $next`

**Return Values**

`\PipeLine`




<hr />


### Middleware::process  

**Description**

```php
public process (\ServerRequestInterface $request, \ResponseInterface $response, callable|null $next)
```

Function process
Process an incoming server request. 

Processes an incoming server request in order to produce a response.  
If unable to produce the response itself, it may delegate to the provided  
request $next handler to do so.  
  
```php  
 //Perform here all persoal code implementation and return $next  
 retrun $next($request);  
```  
  
```php  
   //Or receive um ResponseInterface from $next and procces you ResponseInterface  
   $response = $next($request);  
   ...  
   retrun $response;  
``` 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(\ResponseInterface) $response`
* `(callable|null) $next`

**Return Values**

`\ResponseInterface`




<hr />

