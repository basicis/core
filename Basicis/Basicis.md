# Basicis\Basicis  

Basicis - App

Main class Basicis framework  

## Implements:
Psr\Http\Server\RequestHandlerInterface

## Extend:

Basicis\Http\Server\RequestHandler

## Methods

| Name | Description |
|------|-------------|
|[__construct](#basicis__construct)|Function __construct|
|[clientFileDownload](#basicisclientfiledownload)|Function clientFileDownload|
|[clientFileupload](#basicisclientfileupload)|Function clientFileupload|
|[closure](#basicisclosure)|Function closure|
|[controller](#basiciscontroller)|Function controller|
|[createApp](#basiciscreateapp)|Function createApp Factory|
|[delete](#basicisdelete)|Function detete|
|[get](#basicisget)|Function get|
|[getController](#basicisgetcontroller)|Function getController|
|[getEnv](#basicisgetenv)|Function env|
|[getMiddlewares](#basicisgetmiddlewares)|Function getMiddlewares|
|[getMode](#basicisgetmode)|Function getMode
Getting App operation Mode, development "dev" ou production "production"|
|[getRequest](#basicisgetrequest)|Function getRequest|
|[getResponse](#basicisgetresponse)|Function getResponse|
|[getRoute](#basicisgetroute)|Function getRoute|
|[getRouter](#basicisgetrouter)|Function getRouter|
|[getTimezone](#basicisgettimezone)|Function getTimezone
Getting App Timezone, default "America/Recife"|
|[input](#basicisinput)|Function input
Opens a Stream Resource in Read mode and returns its content|
|[json](#basicisjson)|Function json|
|[loadEnv](#basicisloadenv)|Function env|
|[logger](#basicislogger)|Function logger|
|[output](#basicisoutput)|Function output
Open a Stream Resource in Recording mode and write a text in it, sending headers|
|[patch](#basicispatch)|Function patch|
|[path](#basicispath)|Function path
Return app project root path|
|[post](#basicispost)|Function post|
|[put](#basicisput)|Function put|
|[request](#basicisrequest)|Function request
Alias for getRequest|
|[response](#basicisresponse)|Function response
Alias for getResponse|
|[run](#basicisrun)|Function run|
|[setAfterMiddlewares](#basicissetaftermiddlewares)|Function setAfterMiddlewares|
|[setBeforeMiddlewares](#basicissetbeforemiddlewares)|Function setBeforeMiddlewares|
|[setControllers](#basicissetcontrollers)|Function setControllers|
|[setMode](#basicissetmode)|Function setMode
Setting App operation Mode, development ["dev"|null] ou production ["production"|"prod"]|
|[setRequest](#basicissetrequest)|Function setRequest|
|[setRouteMiddlewares](#basicissetroutemiddlewares)|Function setMiddlewares|
|[setRoutesByAnnotations](#basicissetroutesbyannotations)|Function setRoutesByAnnotations
Receives a class as an argument, and works with the comment blocks as @Route|
|[setRoutesByControllers](#basicissetroutesbycontrollers)|Function setRoutesByControllers
Receives a array of Controller[] with classnames like this '[App\ExampleController, ...]'|
|[setTimezone](#basicissettimezone)|Function setTimezone
Setting app timezone, default America/Recife|
|[setViewFilters](#basicissetviewfilters)|Function setViewFilters|
|[validate](#basicisvalidate)|Function validate|
|[view](#basicisview)|Function view|
|[write](#basiciswrite)|Function write|

## Inherited methods

| Name | Description |
|------|-------------|
|handle|Function handle
Handles a request and produces a response.|



### Basicis::__construct  

**Description**

```php
public __construct (\ServerRequestInterface $request, array $options)
```

Function __construct 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(array) $options`

**Return Values**

`void`


<hr />


### Basicis::clientFileDownload  

**Description**

```php
public clientFileDownload (string $filename)
```

Function clientFileDownload 

 

**Parameters**

* `(string) $filename`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### Basicis::clientFileupload  

**Description**

```php
public clientFileupload (\UploadedFileInterface $infile, string $outfile)
```

Function clientFileupload 

 

**Parameters**

* `(\UploadedFileInterface) $infile`
* `(string) $outfile`

**Return Values**

`array|null`




<hr />


### Basicis::closure  

**Description**

```php
public closure (\Closure $callback)
```

Function closure 

 

**Parameters**

* `(\Closure) $callback`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### Basicis::controller  

**Description**

```php
public controller (string $callback)
```

Function controller 

 

**Parameters**

* `(string) $callback`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### Basicis::createApp  

**Description**

```php
public static createApp (\ServerRequestInterface $request, array $options)
```

Function createApp Factory 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(array) $options`

**Return Values**

`\Basicis`




<hr />


### Basicis::delete  

**Description**

```php
public delete (string $url, string|\Closure $callback, string|array $middlewares)
```

Function detete 

 

**Parameters**

* `(string) $url`
* `(string|\Closure) $callback`
* `(string|array) $middlewares`

**Return Values**

`void`




<hr />


### Basicis::get  

**Description**

```php
public get (string $url, string|\Closure $callback, string|array $middlewares)
```

Function get 

 

**Parameters**

* `(string) $url`
* `(string|\Closure) $callback`
* `(string|array) $middlewares`

**Return Values**

`void`




<hr />


### Basicis::getController  

**Description**

```php
public getController (string $arg)
```

Function getController 

 

**Parameters**

* `(string) $arg`
: [keyname|class]  

**Return Values**

`\Controller|null`




<hr />


### Basicis::getEnv  

**Description**

```php
public static getEnv (string $name)
```

Function env 

 

**Parameters**

* `(string) $name`

**Return Values**

`string|null`




<hr />


### Basicis::getMiddlewares  

**Description**

```php
public getMiddlewares (string $type)
```

Function getMiddlewares 

 

**Parameters**

* `(string) $type`
: ['before'|'route'|'after'|null]  
Return an arra with especified middlewares type or all if no is especified the $type argument  

**Return Values**

`array`




<hr />


### Basicis::getMode  

**Description**

```php
public getMode (void)
```

Function getMode
Getting App operation Mode, development "dev" ou production "production" 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Basicis::getRequest  

**Description**

```php
public getRequest (void)
```

Function getRequest 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ServerRequestInterface`




<hr />


### Basicis::getResponse  

**Description**

```php
public getResponse (int $code, string $reasonPhrase)
```

Function getResponse 

 

**Parameters**

* `(int) $code`
* `(string) $reasonPhrase`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::getRoute  

**Description**

```php
public getRoute (void)
```

Function getRoute 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Route|null`




<hr />


### Basicis::getRouter  

**Description**

```php
public getRouter (void)
```

Function getRouter 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Router`




<hr />


### Basicis::getTimezone  

**Description**

```php
public getTimezone (void)
```

Function getTimezone
Getting App Timezone, default "America/Recife" 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Basicis::input  

**Description**

```php
public static input (string $resourceFileName)
```

Function input
Opens a Stream Resource in Read mode and returns its content 

 

**Parameters**

* `(string) $resourceFileName`
: = "php://input"  

**Return Values**

`void`




<hr />


### Basicis::json  

**Description**

```php
public json (array $data, int $statusCode)
```

Function json 

 

**Parameters**

* `(array) $data`
: = []  
* `(int) $statusCode`
: = 200  

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::loadEnv  

**Description**

```php
public static loadEnv (string $name)
```

Function env 

 

**Parameters**

* `(string) $name`

**Return Values**

`void`




<hr />


### Basicis::logger  

**Description**

```php
public static logger (void)
```

Function logger 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Log`




<hr />


### Basicis::output  

**Description**

```php
public static output (string $resourceFileName, \ServerRequestInterface $request, \ResponseInterface $response)
```

Function output
Open a Stream Resource in Recording mode and write a text in it, sending headers 

 

**Parameters**

* `(string) $resourceFileName`
* `(\ServerRequestInterface) $request`
* `(\ResponseInterface) $response`

**Return Values**

`int`




<hr />


### Basicis::patch  

**Description**

```php
public patch (string $url, string|\Closure $callback, string|array $middlewares)
```

Function patch 

 

**Parameters**

* `(string) $url`
* `(string|\Closure) $callback`
* `(string|array) $middlewares`

**Return Values**

`void`




<hr />


### Basicis::path  

**Description**

```php
public static path (void)
```

Function path
Return app project root path 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Basicis::post  

**Description**

```php
public post (string $url, string|\Closure $callback, string|array $middlewares)
```

Function post 

 

**Parameters**

* `(string) $url`
* `(string|\Closure) $callback`
* `(string|array) $middlewares`

**Return Values**

`void`




<hr />


### Basicis::put  

**Description**

```php
public put (string $url, string|\Closure $callback, string|array $middlewares)
```

Function put 

 

**Parameters**

* `(string) $url`
* `(string|\Closure) $callback`
* `(string|array) $middlewares`

**Return Values**

`void`




<hr />


### Basicis::request  

**Description**

```php
public request (void)
```

Function request
Alias for getRequest 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ServerRequestInterface`




<hr />


### Basicis::response  

**Description**

```php
public response (int $code, string $reasonPhrase)
```

Function response
Alias for getResponse 

 

**Parameters**

* `(int) $code`
* `(string) $reasonPhrase`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::run  

**Description**

```php
public run (void)
```

Function run 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />


### Basicis::setAfterMiddlewares  

**Description**

```php
public setAfterMiddlewares (array $middlewares)
```

Function setAfterMiddlewares 

 

**Parameters**

* `(array) $middlewares`

**Return Values**

`void`




<hr />


### Basicis::setBeforeMiddlewares  

**Description**

```php
public setBeforeMiddlewares (array $middlewares)
```

Function setBeforeMiddlewares 

 

**Parameters**

* `(array) $middlewares`

**Return Values**

`void`




<hr />


### Basicis::setControllers  

**Description**

```php
public setControllers (array $controllers)
```

Function setControllers 

 

**Parameters**

* `(array) $controllers`

**Return Values**

`\Basicis`




<hr />


### Basicis::setMode  

**Description**

```php
public setMode (string $mode)
```

Function setMode
Setting App operation Mode, development ["dev"|null] ou production ["production"|"prod"] 

 

**Parameters**

* `(string) $mode`
: = ["dev"|"production"|"prod"|null]  
Default value "dev" == Development Mode  

**Return Values**

`\Basicis`




<hr />


### Basicis::setRequest  

**Description**

```php
public setRequest (\ServerRequestinterface $request)
```

Function setRequest 

 

**Parameters**

* `(\ServerRequestinterface) $request`

**Return Values**

`\Basicis`




<hr />


### Basicis::setRouteMiddlewares  

**Description**

```php
public setRouteMiddlewares (array $middlewares)
```

Function setMiddlewares 

 

**Parameters**

* `(array) $middlewares`

**Return Values**

`void`




<hr />


### Basicis::setRoutesByAnnotations  

**Description**

```php
public setRoutesByAnnotations (string $class)
```

Function setRoutesByAnnotations
Receives a class as an argument, and works with the comment blocks as @Route 

 

**Parameters**

* `(string) $class`

**Return Values**

`\Basicis`




<hr />


### Basicis::setRoutesByControllers  

**Description**

```php
public setRoutesByControllers (array|\Controller[] $controllers)
```

Function setRoutesByControllers
Receives a array of Controller[] with classnames like this '[App\ExampleController, ...]' 

 

**Parameters**

* `(array|\Controller[]) $controllers`

**Return Values**

`\Basicis`




<hr />


### Basicis::setTimezone  

**Description**

```php
public setTimezone (string $timezone)
```

Function setTimezone
Setting app timezone, default America/Recife 

 

**Parameters**

* `(string) $timezone`

**Return Values**

`\Basicis`




<hr />


### Basicis::setViewFilters  

**Description**

```php
public setViewFilters (array|\TwigFunction[] $filters)
```

Function setViewFilters 

 

**Parameters**

* `(array|\TwigFunction[]) $filters`

**Return Values**

`void`




<hr />


### Basicis::validate  

**Description**

```php
public static validate (string|array $data, string|array $validations, string $class)
```

Function validate 

 

**Parameters**

* `(string|array) $data`
* `(string|array) $validations`
* `(string) $class`

**Return Values**

`bool`




<hr />


### Basicis::view  

**Description**

```php
public view (string $name, array $data, int $statusCode, string $customPath)
```

Function view 

 

**Parameters**

* `(string) $name`
* `(array) $data`
* `(int) $statusCode`
: default=200  
* `(string) $customPath`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::write  

**Description**

```php
public write (string $text, int $statusCode)
```

Function write 

 

**Parameters**

* `(string) $text`
* `(int) $statusCode`
: default=200  

**Return Values**

`\ResponseInterface`




<hr />

