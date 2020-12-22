# Basicis\Router\Route  

Route Class





## Methods

| Name | Description |
|------|-------------|
|[__construct](#route__construct)|Function __construct|
|[getArguments](#routegetarguments)|Function getArguments
Get route arguments|
|[getCallback](#routegetcallback)|Function getCallback
Get route callback if this is a Closure, else return null|
|[getCallbackString](#routegetcallbackstring)|Function getCallbackString
Get route callback if this is a string, else return null|
|[getMethod](#routegetmethod)|Function getMethod
Get route method|
|[getMiddlewares](#routegetmiddlewares)|Function getMiddlewares
Get a array with route middlewares keys|
|[getName](#routegetname)|Function getName
Get route name/url|
|[setArgument](#routesetargument)|Function setArgument
Set route argument|
|[setArguments](#routesetarguments)|Function setArguments
Set route arguments|
|[setCallback](#routesetcallback)|Function setCallback
Set route a callback|




### Route::__construct  

**Description**

```php
public __construct (string $url, string $method, mixed $callback, mixed $middlewares)
```

Function __construct 

 

**Parameters**

* `(string) $url`
: - Route url or signature  
* `(string) $method`
: - Http method url  
* `(mixed) $callback`
: - A function or string corresponding to the url of the controller @ method  
* `(mixed) $middlewares`
: - An array or string middlewares list  

**Return Values**

`void`


<hr />


### Route::getArguments  

**Description**

```php
public getArguments (void)
```

Function getArguments
Get route arguments 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`object|null`




<hr />


### Route::getCallback  

**Description**

```php
public getCallback (void)
```

Function getCallback
Get route callback if this is a Closure, else return null 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Closure|null`




<hr />


### Route::getCallbackString  

**Description**

```php
public getCallbackString (void)
```

Function getCallbackString
Get route callback if this is a string, else return null 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`




<hr />


### Route::getMethod  

**Description**

```php
public getMethod (void)
```

Function getMethod
Get route method 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Route::getMiddlewares  

**Description**

```php
public getMiddlewares (void)
```

Function getMiddlewares
Get a array with route middlewares keys 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`




<hr />


### Route::getName  

**Description**

```php
public getName (void)
```

Function getName
Get route name/url 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Route::setArgument  

**Description**

```php
public setArgument (string $key, mixed $value)
```

Function setArgument
Set route argument 

 

**Parameters**

* `(string) $key`
: - key of argument object  
* `(mixed) $value`
: - value to this key  

**Return Values**

`\Route`




<hr />


### Route::setArguments  

**Description**

```php
public setArguments (array $args)
```

Function setArguments
Set route arguments 

 

**Parameters**

* `(array) $args`
: - Array of arguments  

**Return Values**

`\Route`




<hr />


### Route::setCallback  

**Description**

```php
public setCallback (void)
```

Function setCallback
Set route a callback 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Route`




<hr />

