# Basicis\Router\Router  

Router Class





## Methods

| Name | Description |
|------|-------------|
|[__construct](#router__construct)|Function __constructs|
|[extractArgId](#routerextractargid)|function extractArgId|
|[extractArgRegex](#routerextractargregex)|Function extractArgRegex|
|[findByCount](#routerfindbycount)|Function findByCount|
|[findByMethod](#routerfindbymethod)|Function findByMethod|
|[findByName](#routerfindbyname)|Function findByName|
|[findByRegex](#routerfindbyregex)|Function findByRegex|
|[getResponse](#routergetresponse)|Function getResponse|
|[getRoute](#routergetroute)|Function getRoute|
|[getRoutes](#routergetroutes)|Function getRoutes|
|[group](#routergroup)|group function alias for routerGroup|
|[hasRoute](#routerhasroute)|Function hasRoute|
|[setRequest](#routersetrequest)|Function getResponse|
|[setRoute](#routersetroute)|Function setRoute|
|[setRouteByAnnotation](#routersetroutebyannotation)|Function setRouteByAnnotation
Receives a class as an argument, and works with the comment blocks as @Route|




### Router::__construct  

**Description**

```php
public __construct (\Psr\Http\Message\ServerRequestInterface $request)
```

Function __constructs 

 

**Parameters**

* `(\Psr\Http\Message\ServerRequestInterface) $request`

**Return Values**

`void`




<hr />


### Router::extractArgId  

**Description**

```php
public extractArgId (string $routeNamePart)
```

function extractArgId 

 

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

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### Router::getRoute  

**Description**

```php
public getRoute (string $url, string $method)
```

Function getRoute 

 

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

 

**Parameters**

`This function has no parameters.`

**Return Values**

`array|\Route[]`




<hr />


### Router::group  

**Description**

```php
public group (array $url, string|\Closure $callback, string|array $middlewares)
```

group function alias for routerGroup 

 

**Parameters**

* `(array) $url`
* `(string|\Closure) $callback`
* `(string|array) $middlewares`

**Return Values**

`void`




<hr />


### Router::hasRoute  

**Description**

```php
public hasRoute (string $name, string $method)
```

Function hasRoute 

 

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

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Psr\Http\Message\ServerRequestInterface`




<hr />


### Router::setRoute  

**Description**

```php
public setRoute (string $method, string|array $url, string|\Clousure $callback, string|array $middlewares)
```

Function setRoute 

 

**Parameters**

* `(string) $method`
: = "GET"  
* `(string|array) $url`
: = "/"  
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

