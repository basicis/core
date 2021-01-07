# Basicis\Basicis  

Basicis\Basicis - Main class Basicis framework

## Implements:
Psr\Http\Server\RequestHandlerInterface

## Extend:

Basicis\Http\Server\RequestHandler

## Methods

| Name | Description |
|------|-------------|
|[auth](#basicisauth)|Function auth
Get the app Auth/User by authorization token, it is receive a class Basicis\Auth\AuthInterface|
|[cache](#basiciscache)|Function cache|
|[clientFileDownload](#basicisclientfiledownload)|Function clientFileDownload
Send a file in the body of the http response to the client|
|[clientFileUpload](#basicisclientfileupload)|Function clientFileUpload
Upload one or more files in the body of the http server request from the client|
|[closure](#basicisclosure)|Function closure
Instantiate a Closure object and execute|
|[controller](#basiciscontroller)|Function controller
Instantiate a Basicis\Controller\Controller object and execute the defined method or the standard index method.|
|[createApp](#basiciscreateapp)|Function createApp Factory
Create a instanceof Basicis\Basicis and return it is|
|[enableCache](#basicisenablecache)|Function enableCache
Enable application cache $enable true|
|[extractData](#basicisextractdata)|Function extractData
Extract data on ServerRequest and/or Route url params|
|[getAppDescription](#basicisgetappdescription)|Function getAppDescription
Getting App description string|
|[getAppKey](#basicisgetappkey)|Function getAppKey
Getting hash appKey|
|[getController](#basicisgetcontroller)|Function getController
Get a controller by classname|
|[getMiddlewares](#basicisgetmiddlewares)|Function getMiddlewares
Getting middlewares by type ['before', 'route', 'after' or null to all].|
|[getMode](#basicisgetmode)|Function getMode
Getting App operation Mode, development "dev" ou production "production"|
|[getRequest](#basicisgetrequest)|Function getRequest
Get current server request of app|
|[getResourceInput](#basicisgetresourceinput)|Function getResourceInput
Get app default resource input|
|[getResourceOutput](#basicisgetresourceoutput)|Function getResourceOutput
Get app default resource output|
|[getResponse](#basicisgetresponse)|Function getResponse
Get current response of app|
|[getRoute](#basicisgetroute)|Function getRoute
Get requested Route on router engine instance according to servervrequest.|
|[getRouter](#basicisgetrouter)|Function getRouter
Get the app Router engine instance|
|[getTimezone](#basicisgettimezone)|Function getTimezone
Getting App Timezone, default "America/Recife"|
|[handleError](#basicishandleerror)|Function handleError
Returns a template view with errors occurred during the execution of the application according to http response|
|[input](#basicisinput)|Function input
Open a Stream Resource in Read mode and returns its content|
|[json](#basicisjson)|Function json
Set a array data and status code for write in the http response|
|[loadEnv](#basicisloadenv)|Function loadEnv
Load enviroment variables for use from app|
|[output](#basicisoutput)|Function output
Open a Stream Resource in Recording mode and write a text in it, sending headers|
|[path](#basicispath)|Function path
Return app project root path|
|[redirect](#basicisredirect)|Function redirect
Redirect a Server Request with url, method and optional array of data|
|[request](#basicisrequest)|Function request
Set and/or get current server request of app|
|[response](#basicisresponse)|Function response
Set and/or get current server response of app|
|[run](#basicisrun)|Function run
Finally execute the app instance passed as parameters to standard input and output for php application.|
|[runAndResponse](#basicisrunandresponse)|Function runAndResponse
Run app pipe line and return a instance of ResponseInterface|
|[setAfterMiddlewares](#basicissetaftermiddlewares)|Function setAfterMiddlewares
Setting after middlewares These are executed in the order they were defined.|
|[setAppDescription](#basicissetappdescription)|Function setAppDescription
Setting App description string|
|[setAppKey](#basicissetappkey)|Function setAppKey
Setting hash appKey|
|[setBeforeMiddlewares](#basicissetbeforemiddlewares)|Function setBeforeMiddlewares
Setting before middlewares for app These are executed in the order they were defined.|
|[setControllers](#basicissetcontrollers)|Function setControllers
Setting all controller for app|
|[setMode](#basicissetmode)|Function setMode
Setting App operation Mode, development ["dev" or null] ou production ["production" or "prod"]|
|[setRequest](#basicissetrequest)|Function setRequest
Set current server request of app|
|[setRequestByArray](#basicissetrequestbyarray)|Function setRequestByArray
Set current server request of app by a array argument|
|[setResourceInput](#basicissetresourceinput)|Function setResourceInput
Set app default resource input|
|[setResourceOutput](#basicissetresourceoutput)|Function setResourceOutput
Set app default resource output|
|[setResponse](#basicissetresponse)|Function setResponse
Get current response of app|
|[setRoute](#basicissetroute)|Function setRoute
Set a new route in the app router object|
|[setRouteMiddlewares](#basicissetroutemiddlewares)|Function setMiddlewares
Setting route middlewares for app|
|[setRoutesByAnnotations](#basicissetroutesbyannotations)|Function setRoutesByAnnotations
Receives a class as an argument, and works with the comment blocks as @Route|
|[setRoutesByControllers](#basicissetroutesbycontrollers)|Function setRoutesByControllers
Receives a array of Controller[] with classnames like this '[App\ExampleController, ...]'|
|[setTimezone](#basicissettimezone)|Function setTimezone
Setting app timezone|
|[setViewFilters](#basicissetviewfilters)|Function setViewFilters
Setting filters functions for use into template|
|[view](#basicisview)|Function view
Set a template name, optional data and a optional path for write in the http response.|
|[write](#basiciswrite)|Function write
Set a string and status code for write in the http response|

## Inherited methods

| Name | Description |
|------|-------------|
|__construct|Function __construct
Receives a instance of Basicis\Basicis $app as argument|
|handle|Function handle
Handles a request and produces a response.|



### Basicis::auth  

**Description**

```php
public auth (string $authClass)
```

Function auth
Get the app Auth/User by authorization token, it is receive a class Basicis\Auth\AuthInterface 

 

**Parameters**

* `(string) $authClass`

**Return Values**

`\Auth|null`




<hr />


### Basicis::cache  

**Description**

```php
public cache (void)
```

Function cache 

Get the app CacheItemPool engine instance 

**Parameters**

`This function has no parameters.`

**Return Values**

`\CacheItemPool`




<hr />


### Basicis::clientFileDownload  

**Description**

```php
public clientFileDownload (string $filename, bool $forced)
```

Function clientFileDownload
Send a file in the body of the http response to the client 

 

**Parameters**

* `(string) $filename`
* `(bool) $forced`
: false  

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::clientFileUpload  

**Description**

```php
public clientFileUpload (\UploadedFileInterface $infile, string $outfile)
```

Function clientFileUpload
Upload one or more files in the body of the http server request from the client 

 

**Parameters**

* `(\UploadedFileInterface) $infile`
* `(string) $outfile`

**Return Values**

`array|null`




<hr />


### Basicis::closure  

**Description**

```php
public closure (\Closure $callback, string|int|array|object|null $args)
```

Function closure
Instantiate a Closure object and execute 

 

**Parameters**

* `(\Closure) $callback`
* `(string|int|array|object|null) $args`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::controller  

**Description**

```php
public controller (string $callback, string|int|array|object|null $args)
```

Function controller
Instantiate a Basicis\Controller\Controller object and execute the defined method or the standard index method. 

The key for the controller or class name must be separated from the method name to be executed by `@` or `::`.  
  
- Using into outhers controllers or middlewares and defined for Basicis\Basicis::setControllers  
  
```php  
  $app->controller("example@functionName", $args = [object, array or null]);  
  //or  
  $app->controller("Namespace\Example::functionName", $args = [object, array or null]);  
```` 

**Parameters**

* `(string) $callback`
* `(string|int|array|object|null) $args`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::createApp  

**Description**

```php
public static createApp (\ServerRequestInterface $request, array $options)
```

Function createApp Factory
Create a instanceof Basicis\Basicis and return it is 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(array) $options`

**Return Values**

`\Basicis`




<hr />


### Basicis::enableCache  

**Description**

```php
public enableCache (bool $enable, string $cacheFile)
```

Function enableCache
Enable application cache $enable true 

 

**Parameters**

* `(bool) $enable`
* `(string) $cacheFile`

**Return Values**

`\Basicis`




<hr />


### Basicis::extractData  

**Description**

```php
public static extractData (\ServerRequestInterface $request, \Route $route)
```

Function extractData
Extract data on ServerRequest and/or Route url params 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(\Route) $route`

**Return Values**

`array`




<hr />


### Basicis::getAppDescription  

**Description**

```php
public getAppDescription (void)
```

Function getAppDescription
Getting App description string 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Basicis::getAppKey  

**Description**

```php
public getAppKey (void)
```

Function getAppKey
Getting hash appKey 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Basicis::getController  

**Description**

```php
public getController (string $arg)
```

Function getController
Get a controller by classname 

 

**Parameters**

* `(string) $arg`
: [keyname or class]  

**Return Values**

`\Controller|null`




<hr />


### Basicis::getMiddlewares  

**Description**

```php
public getMiddlewares (string $type)
```

Function getMiddlewares
Getting middlewares by type ['before', 'route', 'after' or null to all]. 

This return a array with especifieds middleware type or all if $type argument is equals null 

**Parameters**

* `(string) $type`
: ['before', 'route', 'after' or null]  

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
Get current server request of app 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ServerRequestInterface`




<hr />


### Basicis::getResourceInput  

**Description**

```php
public getResourceInput (void)
```

Function getResourceInput
Get app default resource input 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Basicis::getResourceOutput  

**Description**

```php
public getResourceOutput (void)
```

Function getResourceOutput
Get app default resource output 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Basicis::getResponse  

**Description**

```php
public getResponse (void)
```

Function getResponse
Get current response of app 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::getRoute  

**Description**

```php
public getRoute (void)
```

Function getRoute
Get requested Route on router engine instance according to servervrequest. 

A ResponseInterface object can be obtained by the getRequest function in the Router instance. 

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
Get the app Router engine instance 

 

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


### Basicis::handleError  

**Description**

```php
public handleError (string $message)
```

Function handleError
Returns a template view with errors occurred during the execution of the application according to http response 

 

**Parameters**

* `(string) $message`

**Return Values**

`\Basicis`




<hr />


### Basicis::input  

**Description**

```php
public static input (string $resourceFileName)
```

Function input
Open a Stream Resource in Read mode and returns its content 

 

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
Set a array data and status code for write in the http response 

- Using into controllers or route callback  
  
```php  
  return $app->json(["test" => "Test with status code default!"]);  
  //or  
  return $app->json(["test" => "Test with status code ok!", "success" => true], 200);  
```` 

**Parameters**

* `(array) $data`
: []  
* `(int) $statusCode`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::loadEnv  

**Description**

```php
public static loadEnv (void)
```

Function loadEnv
Load enviroment variables for use from app 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




<hr />


### Basicis::output  

**Description**

```php
public static output (\ServerRequestInterface $request, \ResponseInterface $response, string $resourceFileName)
```

Function output
Open a Stream Resource in Recording mode and write a text in it, sending headers 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(\ResponseInterface) $response`
* `(string) $resourceFileName`

**Return Values**

`int`




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


### Basicis::redirect  

**Description**

```php
public redirect (string $url, string $method, array $data)
```

Function redirect
Redirect a Server Request with url, method and optional array of data 

 

**Parameters**

* `(string) $url`
* `(string) $method`
* `(array) $data`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::request  

**Description**

```php
public request (void)
```

Function request
Set and/or get current server request of app 

 

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
Set and/or get current server response of app 

 

**Parameters**

* `(int) $code`
* `(string) $reasonPhrase`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::run  

**Description**

```php
public run (string $inputResource, string $outputResource)
```

Function run
Finally execute the app instance passed as parameters to standard input and output for php application. 

By definition the values ​​are respectively "php://input" for input and "php://output" for output. 

**Parameters**

* `(string) $inputResource`
: = "php://input"  
* `(string) $outputResource`
: = "php://output"  

**Return Values**

`int`




<hr />


### Basicis::runAndResponse  

**Description**

```php
public runAndResponse (void)
```

Function runAndResponse
Run app pipe line and return a instance of ResponseInterface 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::setAfterMiddlewares  

**Description**

```php
public setAfterMiddlewares (array $middlewares)
```

Function setAfterMiddlewares
Setting after middlewares These are executed in the order they were defined. 

These are executed after the route middleware and main app handler,  
if the ResponseInterface returned contains status codes greater than 200 or less than 206  
  
```php  
 $app->setAfterMiddlewares([  
    //key no is required  
    "App\\Middlewares\\AfterExample",  
    //...  
 ]);  
``` 

**Parameters**

* `(array) $middlewares`

**Return Values**

`void`




<hr />


### Basicis::setAppDescription  

**Description**

```php
public setAppDescription (string $description)
```

Function setAppDescription
Setting App description string 

 

**Parameters**

* `(string) $description`

**Return Values**

`\Basicis`




<hr />


### Basicis::setAppKey  

**Description**

```php
public setAppKey (string $appKey)
```

Function setAppKey
Setting hash appKey 

 

**Parameters**

* `(string) $appKey`

**Return Values**

`\Basicis`




<hr />


### Basicis::setBeforeMiddlewares  

**Description**

```php
public setBeforeMiddlewares (array $middlewares)
```

Function setBeforeMiddlewares
Setting before middlewares for app These are executed in the order they were defined. 

These are executed before the route middleware and main app handler.  
  
- Setting into config/app-config.php file  
  
```php  
 $app->setBeforeMiddlewares([  
    //key no is required  
    "App\\Middlewares\\BeforeExample",  
    //...  
 ]);  
``` 

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
Setting all controller for app 

- Setting into config/app-config.php file  
  
```php  
 $app->setControllers([  
     //Key required if from use in direct calls via Basicis App instance  
     "example" => "App/Controllers/Example",  
     //..  
 ]);  
```  
- Using into outhers controllers or middlewares  
  
```php  
$app->controller("example@functionName", $args = [object, array or null]);  
```` 

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
Setting App operation Mode, development ["dev" or null] ou production ["production" or "prod"] 

 

**Parameters**

* `(string) $mode`
: ["dev", "production", "prod" or null]  
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
Set current server request of app 

 

**Parameters**

* `(\ServerRequestinterface) $request`

**Return Values**

`\Basicis`




<hr />


### Basicis::setRequestByArray  

**Description**

```php
public setRequestByArray (array $request)
```

Function setRequestByArray
Set current server request of app by a array argument 

 

**Parameters**

* `(array) $request`

**Return Values**

`\Basicis`




<hr />


### Basicis::setResourceInput  

**Description**

```php
public setResourceInput (string $resourceInput)
```

Function setResourceInput
Set app default resource input 

 

**Parameters**

* `(string) $resourceInput`

**Return Values**

`\Basicis`




<hr />


### Basicis::setResourceOutput  

**Description**

```php
public setResourceOutput (string $resourceOutput)
```

Function setResourceOutput
Set app default resource output 

 

**Parameters**

* `(string) $resourceOutput`

**Return Values**

`\Basicis`




<hr />


### Basicis::setResponse  

**Description**

```php
public setResponse (int|null $code, string $reasonPhrase)
```

Function setResponse
Get current response of app 

 

**Parameters**

* `(int|null) $code`
* `(string) $reasonPhrase`

**Return Values**

`\Basicis`




<hr />


### Basicis::setRoute  

**Description**

```php
public setRoute (string|array $url, string|array $method, string|\ControllerInterface|\Clousure $callback, string|array $middlewares)
```

Function setRoute
Set a new route in the app router object 

 

**Parameters**

* `(string|array) $url`
: "/"  
* `(string|array) $method`
: "GET"  
* `(string|\ControllerInterface|\Clousure) $callback`
: null  
* `(string|array) $middlewares`
: null  

**Return Values**

`\Basicis`




<hr />


### Basicis::setRouteMiddlewares  

**Description**

```php
public setRouteMiddlewares (array $middlewares)
```

Function setMiddlewares
Setting route middlewares for app 

- Setting into config/app-config.php file  
  
```php  
 $app->setRouteMiddlewares([  
     //only here, key is required  
     "guest" => "App\\Middlewares\\Guest",  
     "auth" => "App\\Middlewares\\Auth",  
     "example" => "App\\Middlewares\\Example",  
     //...  
 ]);  
```  
  
- Using within a controller when defining the route  
`@Route("/url", "method1", "middleware")` or  
`@Route("/url, ...", "method1, ...", "middleware1, middleware2, ...")`  
  
```  
   /** @Route("/", "get", "example, guest") *\/  
   public function index($app, $args)  
   {  
       return $app->view("welcome");  
   }  
  
   /** @Route("/dashboard", "get", "auth") *\/  
   public function painel($app, $args)  
   {  
       return $app->view("welcome");  
   }  
```` 

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
Setting app timezone 

 

**Parameters**

* `(string) $timezone`
: "America/Recife" if this is null  

**Return Values**

`\Basicis`




<hr />


### Basicis::setViewFilters  

**Description**

```php
public setViewFilters (array|\TwigFunction[] $filters)
```

Function setViewFilters
Setting filters functions for use into template 

- Setting into config/app-config.php file  
  
```php  
 $app->setViewFilters([  
    //here, key is required  
    "isTrue" => function ($value = true) {  
        return $value;  
    }  
 ]);  
```  
  
- Using into Twig Template file  
  
```  
  <p>Var is True: {{isTrue($var = true)}}<p>  
```  
  
or  
  
```  
  {% if isTrue(var) %}  
    <p>{{varTextHere}}</p>  
  {% endif %}  
``` 

**Parameters**

* `(array|\TwigFunction[]) $filters`

**Return Values**

`void`




<hr />


### Basicis::view  

**Description**

```php
public view (string $name, array $data, string $customPath)
```

Function view
Set a template name, optional data and a optional path for write in the http response. 

If template especified no not found, a ResponseInterface with status code 404 is returned.  
  
- Using into controllers controllers or route callback  
  
Starting from the idea that we have a template called `welcome.[html, php or twig]` inside `storage/templates/`  
or `my-custom/path/`, we have the following code to return this view:  
  
```php  
  return $app->view("welcome", $args = ["test" => "Test ok!"]);  
  //or  
   return $app->view("welcome", $args = ["test" => true, "test2" => "Test ok!"], "my-custom/path/");  
````  
  
- Using into Twig Template file  
```  
  <p>{{test2}}</p>  
  <p>Var is True: {{test}}</p>  
``` 

**Parameters**

* `(string) $name`
* `(array) $data`
* `(string) $customPath`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::write  

**Description**

```php
public write (string $text, int|null $statusCode)
```

Function write
Set a string and status code for write in the http response 

- Using into controllers or route callback  
  
```php  
  return $app->write("My text with status code default!");  
  //or  
  return $app->write("My text with status code 200!", 200);  
```` 

**Parameters**

* `(string) $text`
* `(int|null) $statusCode`

**Return Values**

`\ResponseInterface`




<hr />

