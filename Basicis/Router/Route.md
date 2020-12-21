# Basicis\Router\Route  

Route Class





## Methods

| Name | Description |
|------|-------------|
|[__construct](#route__construct)|Function __construct|
|[getArguments](#routegetarguments)|Function getArguments|
|[getCallback](#routegetcallback)|Function getCallback|
|[getCallbackString](#routegetcallbackstring)|Function getCallbackString|
|[getMethod](#routegetmethod)|Function getMethod|
|[getMiddlewares](#routegetmiddlewares)|Function getMiddlewares|
|[getName](#routegetname)|Function getName|
|[setArgument](#routesetargument)|Function setArgument|
|[setArguments](#routesetarguments)|Function setArguments|
|[setCallback](#routesetcallback)|Function setCallback|




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

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Route`




<hr />

