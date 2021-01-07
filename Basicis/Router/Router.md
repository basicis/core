# Basicis\Router\Router  

Router Class





## Methods

| Name | Description |
|------|-------------|
|[__construct](#router__construct)|Function __constructs|
|[extractArgId](#routerextractargid)|Function extractArgId
Extract a argument id/name of route name  part|
|[extractArgRegex](#routerextractargregex)|Function extractArgRegex
Extract a argument regex of route name part|
|[findByCount](#routerfindbycount)|Function findByCount
Find all routes by count spaces bar "/"|
|[findByMethod](#routerfindbymethod)|Function findByMethod
Find all routes by method|
|[findByName](#routerfindbyname)|Function findByName
Find a route by name/url|
|[findByRegex](#routerfindbyregex)|Function findByRegex
Find a route by regular expression|
|[getResponse](#routergetresponse)|Function getResponse
Get a ResponseInterface Object or router run|
|[getRoute](#routergetroute)|Function getRoute
Get route requested|
|[getRoutes](#routergetroutes)|Function getRoutes
Get a array with all routes into instance of router|
|[hasRoute](#routerhasroute)|Function hasRoute
Check if route match exists for name and method|
|[setRequest](#routersetrequest)|Function getResponse
Set a ServerRequestInterface Object for router run|
|[setRoute](#routersetroute)|Function setRoute
Set a route for router|
|[setRouteByAnnotation](#routersetroutebyannotation)|Function setRouteByAnnotation
Receives a class as an argument, and works with the comment blocks as @Route|




### Router::__construct  

**Description**

```php
public __construct (\ServerRequestInterface|null $request)
```

Function __constructs 

 

**Parameters**

* `(\ServerRequestInterface|null) $request`

**Return Values**

`void`




<hr />


### Router::extractArgId  

**Description**

```php
public extractArgId (string $routeNamePart)
```

Function extractArgId
Extract a argument id/name of route name  part 

 

**Parameters**

* `(string) $routeNamePart`

**Return Values**

`string|null`




<hr />


### Router::extractArgRegex  

**Description**

```php
public extractArgRegex (string $routeNamePart)
```

Function extractArgRegex
Extract a argument regex of route name part 

 

**Parameters**

* `(string) $routeNamePart`

**Return Values**

`string|null`




<hr />


### Router::findByCount  

**Description**

```php
public findByCount (string $url, array $routes)
```

Function findByCount
Find all routes by count spaces bar "/" 

 

**Parameters**

* `(string) $url`
* `(array) $routes`

**Return Values**

`\Route[]`




<hr />


### Router::findByMethod  

**Description**

```php
public findByMethod (string $url, array $routes)
```

Function findByMethod
Find all routes by method 

 

**Parameters**

* `(string) $url`
* `(array) $routes`

**Return Values**

`array`




<hr />


### Router::findByName  

**Description**

```php
public findByName (string $url)
```

Function findByName
Find a route by name/url 

 

**Parameters**

* `(string) $url`

**Return Values**

`array`




<hr />


### Router::findByRegex  

**Description**

```php
public findByRegex (string $url)
```

Function findByRegex
Find a route by regular expression 

 

**Parameters**

* `(string) $url`

**Return Values**

`array|null`




<hr />


### Router::getResponse  

**Description**

```php
public getResponse (void)
```

Function getResponse
Get a ResponseInterface Object or router run 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ResponseInterface`




<hr />


### Router::getRoute  

**Description**

```php
public getRoute (string $url, string $method)
```

Function getRoute
Get route requested 

 

**Parameters**

* `(string) $url`
* `(string) $method`
: = 'GET'  

**Return Values**

`\Route|null`




<hr />


### Router::getRoutes  

**Description**

```php
public getRoutes (void)
```

Function getRoutes
Get a array with all routes into instance of router 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`array|\Route[]`




<hr />


### Router::hasRoute  

**Description**

```php
public hasRoute (string $name, string $method)
```

Function hasRoute
Check if route match exists for name and method 

 

**Parameters**

* `(string) $name`
* `(string) $method`

**Return Values**

`bool`




<hr />


### Router::setRequest  

**Description**

```php
public setRequest (void)
```

Function getResponse
Set a ServerRequestInterface Object for router run 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ServerRequestInterface`




<hr />


### Router::setRoute  

**Description**

```php
public setRoute (string|array $url, string|array $method, string|\Clousure $callback, string|array $middlewares)
```

Function setRoute
Set a route for router 

 

**Parameters**

* `(string|array) $url`
: = "/"  
* `(string|array) $method`
: = "GET"  
* `(string|\Clousure) $callback`
: = null  
* `(string|array) $middlewares`
: = null  

**Return Values**

`\Router`




<hr />


### Router::setRouteByAnnotation  

**Description**

```php
public setRouteByAnnotation (string $annotation, string $callback)
```

Function setRouteByAnnotation
Receives a class as an argument, and works with the comment blocks as @Route 

 

**Parameters**

* `(string) $annotation`
* `(string) $callback`

**Return Values**

`void`




<hr />

