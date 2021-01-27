# Basicis\Basicis  

Basicis\Basicis - Main class Basicis framework

## Implements:
Basicis\Http\Server\RequestHandlerInterface



## Methods

| Name | Description |
|------|-------------|
|[__construct](#basicis__construct)|Function __construct
Construct a instanceof Basicis\Basicis lovingly named $app|
|[__invoke](#basicis__invoke)|Function runAndResponse
Run app pipe line and return a instance of ResponseInterface|
|[auth](#basicisauth)|Function auth
Get the app Auth/User by authorization token, it is receive a class Basicis\Auth\AuthInterface|
|[cache](#basiciscache)|Function cache|
|[cacheIsEnabled](#basiciscacheisenabled)|Function cacheIsEnabled
Check if app cache is enabled and return boolean|
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
|[error](#basiciserror)|Function error
Return a view error reporting html or json|
|[extractCallbackToArray](#basicisextractcallbacktoarray)|Function extractCallbackToArray
Extract and return a array with controller name/class and method or null|
|[getController](#basicisgetcontroller)|Function getController
Get a controller by classname|
|[getDescription](#basicisgetdescription)|Function getDescription
Getting App description string|
|[getMiddlewares](#basicisgetmiddlewares)|Function getMiddlewares
Getting middlewares by type ['before', 'route', 'after' or null to all].|
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
|[handle](#basicishandle)|handle function
Handles the callback function returned by routing engineering and executes it, this return a ResponseInterface|
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
|[pipeLine](#basicispipeline)|Function pipeLine
Run set and middlewares levels pipeline and return a instanceof ResponseInterface|
|[redirect](#basicisredirect)|Function redirect
Redirect a Server Request with url, method and optional array of data|
|[request](#basicisrequest)|Function request
Set and/or get current server request of app|
|[response](#basicisresponse)|Function response
Set and/or get current server response of app|
|[run](#basicisrun)|Function run
Finally execute the app instance passed as parameters to standard input and output for php application.|
|[setAfterMiddlewares](#basicissetaftermiddlewares)|Function setAfterMiddlewares
Setting after middlewares These are executed in the order they were defined.|
|[setBeforeMiddlewares](#basicissetbeforemiddlewares)|Function setBeforeMiddlewares
Setting before middlewares for app These are executed in the order they were defined.|
|[setControllers](#basicissetcontrollers)|Function setControllers
Setting all controller for app|
|[setMiddlewares](#basicissetmiddlewares)|Function setMiddlewares
Set all middlewares for the app at once|
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
|[setRouteMiddlewares](#basicissetroutemiddlewares)|Function setRouteMiddlewares
Setting route middlewares for app|
|[setRoutesByAnnotations](#basicissetroutesbyannotations)|Function setRoutesByAnnotations
Receives a class as an argument, and works with the comment blocks as @Route|
|[setRoutesByControllers](#basicissetroutesbycontrollers)|Function setRoutesByControllers
Receives a array of Controller[] with classnames like this '[App\ExampleController, ...]'|
|[setViewFilters](#basicissetviewfilters)|Function setViewFilters
Setting filters functions for use into template|
|[view](#basicisview)|Function view
Set a template name, optional data and a optional path for write in the http response.|
|[write](#basiciswrite)|Function write
Set a string and status code for write in the http response|




### Basicis::__construct  

**Description**

```php
public __construct (\ServerRequestInterface $request)
```

Function __construct
Construct a instanceof Basicis\Basicis lovingly named $app 

 

**Parameters**

* `(\ServerRequestInterface) $request`

**Return Values**

`void`


<hr />


### Basicis::__invoke  

**Description**

```php
public __invoke (\ServerRequestInterface $request, \ResponseInterface $response, callable $next)
```

Function runAndResponse
Run app pipe line and return a instance of ResponseInterface 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(\ResponseInterface) $response`
* `(callable) $next`

**Return Values**

`\ResponseInterface`




<hr />


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

`\CacheItemPool|null`




<hr />


### Basicis::cacheIsEnabled  

**Description**

```php
public cacheIsEnabled (void)
```

Function cacheIsEnabled
Check if app cache is enabled and return boolean 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




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
public controller (\ServerRequestInterface $request, \ResponseInterface $response, string $callback)
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

* `(\ServerRequestInterface) $request`
* `(\ResponseInterface) $response`
* `(string) $callback`

**Return Values**

`\ResponseInterface`




<hr />


### Basicis::createApp  

**Description**

```php
public static createApp (\ServerRequestInterface|array $request)
```

Function createApp Factory
Create a instanceof Basicis\Basicis and return it is 

 

**Parameters**

* `(\ServerRequestInterface|array) $request`

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


### Basicis::error  

**Description**

```php
public error (int $code, string $message)
```

Function error
Return a view error reporting html or json 

 

**Parameters**

* `(int) $code`
* `(string) $message`

**Return Values**

`\Psr\Http\Message\ResponseInterface`




<hr />


### Basicis::extractCallbackToArray  

**Description**

```php
public extractCallbackToArray (string $callback)
```

Function extractCallbackToArray
Extract and return a array with controller name/class and method or null 

 

**Parameters**

* `(string) $callback`

**Return Values**

`array|null`




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


### Basicis::getDescription  

**Description**

```php
public getDescription (string $descriptionDefault)
```

Function getDescription
Getting App description string 

 

**Parameters**

* `(string) $descriptionDefault`

**Return Values**

`string`




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


### Basicis::handle  

**Description**

```php
public handle (\ServerRequestInterface $request, \ResponseInterface $response, callable $next)
```

handle function
Handles the callback function returned by routing engineering and executes it, this return a ResponseInterface 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(\ResponseInterface) $response`
* `(callable) $next`

**Return Values**

`\ResponseInterface`




**Throws Exceptions**


`\InvalidArgumentException`


<hr />


### Basicis::handleError  

**Description**

```php
public handleError (string $name)
```

Function handleError
Returns a template view with errors occurred during the execution of the application according to http response 

 

**Parameters**

* `(string) $name`

**Return Values**

`\ResponseInterface`




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
public static output (\ResponseInterface $response, string $resourceFileName)
```

Function output
Open a Stream Resource in Recording mode and write a text in it, sending headers 

 

**Parameters**

* `(\ResponseInterface) $response`
* `(string) $resourceFileName`

**Return Values**

`int`

> size of stream writed content or "0"


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


### Basicis::pipeLine  

**Description**

```php
public pipeLine (\ServerRequestInterface $request, \ResponseInterface|null $response, callable $next)
```

Function pipeLine
Run set and middlewares levels pipeline and return a instanceof ResponseInterface 

 

**Parameters**

* `(\ServerRequestInterface) $request`
* `(\ResponseInterface|null) $response`
* `(callable) $next`

**Return Values**

`\ResponseInterface`




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
public response (int|\ResponseInterface $code, string $reasonPhrase)
```

Function response
Set and/or get current server response of app 

 

**Parameters**

* `(int|\ResponseInterface) $code`
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
: "php://input"  
* `(string) $outputResource`
: "php://output"  

**Return Values**

`int`




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


### Basicis::setMiddlewares  

**Description**

```php
public setMiddlewares (void)
```

Function setMiddlewares
Set all middlewares for the app at once 

- Setting into config/app-config.php file  
  
```php  
 $app->setMiddlewares(  
     [  
         //key no is required  
         "App\\Middlewares\\BeforeExample",  
         //...  
     ],  
     [  
         //only here, key is required  
         "guest" => "App\\Middlewares\\Guest",  
         "auth" => "App\\Middlewares\\Auth",  
         "example" => "App\\Middlewares\\Example",  
         //...  
     ],  
     [  
        //key no is required  
        "App\\Middlewares\\AfterExample",  
        //...  
     ]  
 );  
``` 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### Basicis::setRequest  

**Description**

```php
public setRequest (\ServerRequestInterface $request)
```

Function setRequest
Set current server request of app 

 

**Parameters**

* `(\ServerRequestInterface) $request`

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

Function setRouteMiddlewares
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

