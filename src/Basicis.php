<?php
namespace Basicis;

use Basicis\Auth\Auth;
use Basicis\Auth\AuthInterface;
use Basicis\Auth\Token;
use Basicis\Core\Log;
use Basicis\Core\Validator;
use Basicis\Core\Annotations;
use Basicis\Model\Model;
use Basicis\Model\Models;
use Basicis\Router\RouterFactory;
use Basicis\Router\Router;
use Basicis\Router\Route;
use Basicis\Cache\CacheItemPool;
use Basicis\View\View;
use Basicis\Http\Message\ServerRequest;
use Basicis\Http\Server\RequestHandler;
use Basicis\Http\Message\Response;
use Basicis\Http\Message\Uri;
use Basicis\Http\Message\ServerRequestFactory;
use Basicis\Http\Message\ResponseFactory;
use Basicis\Http\Message\StreamFactory;
use Basicis\Controller\Controller;
use Basicis\Controller\ControllerInterface;
use Basicis\Http\Server\Middleware;
use Basicis\Exceptions\InvalidArgumentException;
use Basicis\Exceptions\BasicisException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Twig\TwigFunction;
use Dotenv\Dotenv;
use \Mimey\MimeTypes;

/**
 * Basicis\Basicis - Main class Basicis framework
 *
 * @category Basicis
 * @package  Basicis
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core
 */
class Basicis extends RequestHandler
{
    /**
     * $resourceInput variable
     * @var string
     */
    private $resourceInput = "php://input";

    /**
     * $resourceOutput variable
     * @var string
     */
    private $resourceOutput = "php://output";

    /**
     * $appKey variable
     *
     * @var String
     */
    private $appKey = "default-appkey";

    /**
     * $mode variable
     *
     * @var String
     */
    private $mode = "dev";

    /**
     * $timezone variable
     *
     * @var String
     */
    private $timezone = "America/Recife";

    /**
     * $appDescription variable
     *
     * @var string
     */
    private $appDescription = "A Application Basicis Framework!";

    /**
     * $router variable
     *
     * @var Router
     */
    private $router;

    /**
     * $router variable
     *
     * @var Route
     */
    private $route;

    /**
     * $cache variable
     *
     * @var CacheItemPool
     */
    private $cache;

    /**
     * $enableCache variable
     *
     * @var bool
     */
    private $enableCache = false;

    /**
     * $request variable
     *
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * $response variable
     *
     * @var ResponseInterface
     */
    private $response;

    /**
     * $view variable
     *
     * @var String
     */
    private $view = "";

    /**
     * $controllers variable
     *
     * @var array
     */
    private $controllers = [];

    /**
     * $middlewares variable
     *
     * @var array
     */
    private $middlewares = [
        "before" => [],
        "route" => [],
        "after" => [],
    ];

    /**
     * $viewFilters variable
     *
     * @var array
     */
    private $viewFilters = [];

    /**
     * $auth variable
     *
     * @var Auth;
     */
    private $auth;


    /**
     * Function __construct
     * Construct a instanceof Basicis\Basicis lovingly named $app
     *
     * @param ServerRequestInterface $request
     * @param array $options Acceptables options [mode=string, timezone=string, appDescription=string, appKey=string]
     */
    public function __construct(ServerRequestInterface $request, array $options = [])
    {
        $this->enableCache($options["enableCache"] ?? false, self::path()."cache/app");
        
        if ($this->enableCache && $this->cache->hasItem("router")) {
            $this->router = $this->cache->getItem("router")->get();
        }

        if (!$this->router instanceof Router) {
            $this->router = RouterFactory::create();
            if ($this->enableCache) {
                $this->cache->addItem("router", $this->router, "10 minutes")->commit();
            }
        }

        if ($this->enableCache && $this->cache->hasItem("controllers")) {
            $this->setControllers($this->cache->getItem("controllers")->get());
        }
        
        $this->setMode($options['mode'] ?? "dev");
        $this->setTimezone($options['timezone'] ?? null);
        $this->setAppKey($options['appKey'] ?? null);
        $this->setAppDescription($options['appDescription'] ?? null);

        $this->setRequest($request);
        $this->response = (ResponseFactory::create())->withHeader(
            "X-Powered-By",
            $options['appDescription'] ?? $this->getAppDescription()
        );
    }



    /**
     * Function createApp Factory
     * Create a instanceof Basicis\Basicis and return it is
     *
     * @param  ServerRequestInterface $request
     * @param  array $options
     * @return Basicis
     */
    public static function createApp(ServerRequestInterface $request = null, array $options = []) : Basicis
    {
        self::loadEnv();
        return new Basicis($request ?? ServerRequestFactory::create('GET', '/'), $options);
    }

   

    /**
     * Function setControllers
     * Setting all controller for app
     *
     * - Setting into config/app-config.php file
     *
     * ```php
     *  $app->setControllers([
     *      //Key required if from use in direct calls via Basicis App instance
     *      "example" => "App/Controllers/Example",
     *      //..
     *  ]);
     * ```
     * - Using into outhers controllers or middlewares
     *
     * ```php
     * $app->controller("example@functionName", $args = [object, array or null]);
     * ````
     *
     * @param array $controllers
     *
     * @return Basicis
     */
    public function setControllers(array $controllers = []) : Basicis
    {
        if (count($this->controllers) === 0) {
            foreach ($controllers as $key => $value) {
                $class = $value;
                if ($value instanceof controller) {
                    $class = get_class($value);
                    $controllers[$key] = get_class($value);
                }

                if (!is_string($key) || !class_exists($class) | !(new $value() instanceof Controller)) {
                    throw new InvalidArgumentException("Unidentified key or class 
                                    Basicis\Controller\Controller instance.");
                    unset($controllers[$key]);
                }
            }

            $this->controllers = $controllers;
            $this->setRoutesByControllers($controllers);

            if ($this->enableCache) {
                $this->cache->addItem("controllers", $controllers, "2 minutes")->commit();
            }
        }

        return $this;
    }



    /**
     * Function getController
     * Get a controller by classname
     *
     * @param string $arg [keyname or class]
     *
     * @return Controller|null
     */
    public function getController(string $arg) : ?Controller
    {
        if (class_exists($arg) && new $arg() instanceof Controller) {
            foreach ($this->controllers as $class) {
                if ($class === $arg) {
                    return new $class();
                }
            }
        }
        
        if (key_exists($arg, $this->controllers)) {
            return new $this->controllers[$arg]();
        }

        throw new InvalidArgumentException("Unidentified key for Basicis\Controller\Controller instance.");
        return null;
    }



    /**
     * Function getControllerKey
     * Get a controller key by classname
     *
     * @param string $class
     *
     * @return Controller|null
     */
    private function getControllerKey(string $class) : ?string
    {
        foreach ($this->controllers as $key => $value) {
            if ($value === $class) {
                return $key;
            }
        }
        return null;
    }




    /**
     * Function filterMiddlewares
     * Filter middlewares class on setting
     *
     * @param array   $middlewares
     * @param boolean $requireKey false If A middleware key must be defined
     * @return array
     */
    private function filterMiddlewares(array $middlewares = [], $requireKey = false) : array
    {
        foreach ($middlewares as $key => $middleware) {
            if (($requireKey && !is_string($key)) && !(new $middleware() instanceof RequestHandlerInterface)) {
                throw new InvalidArgumentException(
                    "Unidentified key or Psr\Http\Server\RequestHandlerInterface instance."
                );
                unset($middlewares[$key]);
            }
        }
        return $middlewares;
    }


    /**
     * Function setMiddlewares
     * Setting route middlewares for app
     *
     * - Setting into config/app-config.php file
     *
     * ```php
     *  $app->setRouteMiddlewares([
     *      //only here, key is required
     *      "guest" => "App\\Middlewares\\Guest",
     *      "auth" => "App\\Middlewares\\Auth",
     *      "example" => "App\\Middlewares\\Example",
     *      //...
     *  ]);
     * ```
     *
     * - Using within a controller when defining the route
     * `@Route("/url", "method1", "middleware")` or
     * `@Route("/url, ...", "method1, ...", "middleware1, middleware2, ...")`
     *
     * ```
     *    /** @Route("/", "get", "example, guest") *\/
     *    public function index($app, $args)
     *    {
     *        return $app->view("welcome");
     *    }
     *
     *    /** @Route("/dashboard", "get", "auth") *\/
     *    public function painel($app, $args)
     *    {
     *        return $app->view("welcome");
     *    }
     * ````
     *
     * @param array $middlewares
     *
     * @return void
     */
    public function setRouteMiddlewares(array $middlewares = []) : Basicis
    {
        try {
            $this->middlewares['route'] = $this->filterMiddlewares($middlewares, true);
        } catch (InvalidArgumentException $e) {
            $this->middlewares['route'] = [];
            (new InvalidArgumentException($e->getMessage(), $e->getCode(), $e))->log();
        }
        return $this;
    }


    /**
     * Function setBeforeMiddlewares
     * Setting before middlewares for app These are executed in the order they were defined.
     *
     * These are executed before the route middleware and main app handler.
     *
     * - Setting into config/app-config.php file
     *
     * ```php
     *  $app->setBeforeMiddlewares([
     *     //key no is required
     *     "App\\Middlewares\\BeforeExample",
     *     //...
     *  ]);
     * ```
     *
     * @param array $middlewares
     *
     * @return void
     */
    public function setBeforeMiddlewares(array $middlewares = []) : Basicis
    {
        try {
            $this->middlewares['before'] = $this->filterMiddlewares($middlewares);
        } catch (InvalidArgumentException $e) {
            $this->middlewares['before'] = [];
            (new InvalidArgumentException($e->getMessage(), $e->getCode(), $e))->log();
        }
        return $this;
    }


    /**
     * Function setAfterMiddlewares
     * Setting after middlewares These are executed in the order they were defined.
     *
     * These are executed after the route middleware and main app handler,
     * if the ResponseInterface returned contains status codes greater than 200 or less than 206
     *
     * ```php
     *  $app->setAfterMiddlewares([
     *     //key no is required
     *     "App\\Middlewares\\AfterExample",
     *     //...
     *  ]);
     * ```
     *
     * @param array $middlewares
     *
     * @return void
     */
    public function setAfterMiddlewares(array $middlewares = []) : Basicis
    {
        try {
            $this->middlewares['after'] = $this->filterMiddlewares($middlewares);
        } catch (InvalidArgumentException $e) {
            $this->middlewares['after'] = [];
            (new InvalidArgumentException($e->getMessage(), $e->getCode(), $e))->log();
        }
        return $this;
    }



    /**
     * Function getMiddlewares
     * Getting middlewares by type ['before', 'route', 'after' or null to all].
     *
     * This return a array with especifieds middleware type or all if $type argument is equals null
     *
     * @param string $type ['before', 'route', 'after' or null]
     * @return array
     */
    public function getMiddlewares(string $type = null) : array
    {
        if ($type !== null && key_exists($type, $this->middlewares)) {
            return $this->middlewares[$type];
        }
        return $this->middlewares;
    }


    /**
     * Function handleBeforeMiddlewares
     * Handles middleware prior to the route and executes it, this return a Basicis
     *
     * @return Basicis
     */
    private function handleBeforeMiddlewares() : Basicis
    {
        //Before middlewares here
        $this->response = (new Middleware($this, "before"))->run();
        return $this;
    }


    /**
     * Function middlewaresHandle
     * Handles route middleware and executes it, this return a Basicis
     *
     * @param  string|array $middlewares
     * @return Basicis
     */
    private function handleRouteMiddlewares($middlewares) : Basicis
    {
        //Run route middlewares
        $middlewaresArray = [];
        foreach (is_string($middlewares) ? explode(",", $middlewares) : $middlewares as $middleware) {
            if (key_exists($middleware, $this->middlewares["route"])) {
                $middlewaresArray[] =  $this->middlewares["route"][$middleware];
            }
        }
        $this->response =  (new Middleware($this, $middlewaresArray))->run();
        return $this;
    }


    /**
     * Function handleAfterMiddlewares
     * Handles middleware after the route and executes it, this return a instance of Basicis
     *
     * @return Basicis
     */
    private function handleAfterMiddlewares() : Basicis
    {
        //After middlewares here
        $this->response = (new Middleware($this, "after"))->run();
        return $this;
    }


    /**
     * Function path
     * Return app project root path
     *
     * @return string
     */
    public static function path() : string
    {
        $path = getcwd();
        if (str_ends_with($path, "public")) {
            $path .= "/..";
        }
        return $path .= "/";
    }


    /**
     * Function loadEnv
     * Load enviroment variables for use from app
     *
     * @return boolean
     */
    public static function loadEnv() : bool
    {
        $dotenv = new \Symfony\Component\Dotenv\Dotenv();
        $testEnv = self::path().'.env.test';
        $localEnv = self::path().'.env.local';
        $defaultEnv = self::path().'.env';
        
        if (file_exists($testEnv)) {
            $dotenv->load($testEnv);
            return true;
        }

        if (file_exists($localEnv)) {
            $dotenv->load($localEnv);
            return true;
        }
        
        if (file_exists($defaultEnv)) {
            $dotenv->load($defaultEnv);
            return true;
        }

        return false;
    }


    /**
     * Function setAppDescription
     * Setting App description string
     *
     * @param string $description
     * @return Basicis
     */
    public function setAppDescription(string $description = null) : Basicis
    {
        if ($description === null) {
            $this->appDescription = "A Basicis Framework Project!";
            return $this;
        }
        $this->appDescription = $description;
        return $this;
    }

    /**
     * Function getResourceInput
     * Get app default resource input
     *
     * @return string
     */
    public function getResourceInput() : string
    {
        return $this->resourceInput;
    }


    /**
     * Function setResourceInput
     * Set app default resource input
     *
     * @param string $resourceInput
     * @return Basicis
     */
    public function setResourceInput(string $resourceInput) : Basicis
    {
        $stream = (new StreamFactory)->createStreamFromFile($resourceInput, "r+");
        if ($stream->isValidResource() && ($resourceInput === $stream->getMetadata("uri"))) {
            $this->resourceInput = $resourceInput;
        }
        $stream->close();
        return $this;
    }


    /**
     * Function getResourceOutput
     * Get app default resource output
     *
     * @return string
     */
    public function getResourceOutput() : string
    {
        return $this->resourceOutput;
    }

    /**
     * Function setResourceOutput
     * Set app default resource output
     *
     * @param string $resourceOutput
     *
     * @return Basicis
     */
    public function setResourceOutput(string $resourceOutput) : Basicis
    {
        $stream = (new StreamFactory)->createStreamFromFile($resourceOutput, "w+");
        if ($stream->isValidResource() && ($resourceOutput === $stream->getMetadata("uri"))) {
            $this->resourceOutput = $resourceOutput;
        }
        $stream->close();
        return $this;
    }


    /**
     * Function getAppDescription
     * Getting App description string
     *
     * @return String
     */
    public function getAppDescription() : String
    {
        return $this->appDescription;
    }



    /**
     * Function setMode
     * Setting App operation Mode, development ["dev" or null] ou production ["production" or "prod"]
     *
     * @param string $mode ["dev", "production", "prod" or null]
     * Default value "dev" == Development Mode
     * @return Basicis
     */
    public function setMode(string $mode = "dev") : Basicis
    {
        $displayErrors = 1;
        $appEnv = "APP_ENV=dev";
        $errorReporting = E_ALL;

        if (in_array($mode, ["production", "prod"])) {
            $appEnv = "APP_ENV=production";
            $displayErrors = 0;
            $mode = "production";
        }

        error_reporting($errorReporting);
        ini_set('display_errors', $displayErrors);
        putenv($appEnv);
        $this->mode = in_array($mode, ["production", "prod"]) ?  "production" : "dev";
        return $this;
    }



    /**
     * Function getMode
     * Getting App operation Mode, development "dev" ou production "production"
     *
     * @return String
     */
    public function getMode() : String
    {
        return $this->mode;
    }


    /**
     * Function getAppKey
     * Getting hash appKey
     *
     * @return String
     */
    public function getAppKey() : String
    {
        return $this->appKey;
    }


    /**
     * Function setAppKey
     * Setting hash appKey
     *
     * @param string $appKey
     * @return Basicis
     */
    public function setAppKey(string $appKey = null) : Basicis
    {
        if ($appKey === null) {
            $hash = "";
            if (file_exists(self::path()."composer.lock")) {
                $hash = ((array) json_decode(self::input(self::path()."composer.lock")))["content-hash"];
                $this->appKey = "default-appkey". $hash;
            }
            return $this;
        }
        $this->appKey = $appKey;
        return $this;
    }


    /**
     * Function enableCache
     * Enable application cache $enable true
     *
     * @param bool $enable
     * @param string $cacheFile
     *
     * @return Basicis
     */
    public function enableCache(bool $enable = true, string $cacheFile = null)  : Basicis
    {
        $this->enableCache = $enable;
        if ($enable) {
            $this->cache = new CacheItemPool($cacheFile);
        }
        return $this;
    }


    /**
     * Function setTimezone
     * Setting app timezone
     *
     * @param string $timezone "America/Recife" if this is null
     * @return Basicis
     */
    public function setTimezone(string $timezone = null) : Basicis
    {
        $this->timezone = isset($timezone) ? $timezone : date_default_timezone_get();
        date_default_timezone_set($this->timezone);
        return $this;
    }

    /**
     * Function getTimezone
     * Getting App Timezone, default "America/Recife"
     *
     * @return String
     */
    public function getTimezone() : String
    {
        return $this->timezone;
    }


    /**
     * Function getRequest
     * Get current server request of app
     *
     * @return ServerRequestInterface
     */
    public function getRequest() : ServerRequestInterface
    {
        return $this->request;
    }

    
    /**
     * Function setRequest
     * Set current server request of app
     *
     * @param ServerRequestinterface $request
     * @return Basicis
     */
    public function setRequest(ServerRequestinterface $request) : Basicis
    {
        $this->request = $request->withParsedBody(self::input($this->getResourceInput()));
        $this->router->setRequest($this->request);
        return $this;
    }

    /**
     * Function setRequestByArray
     * Set current server request of app by a array argument
     *
     * @param array $request
     * @return Basicis
     */
    public function setRequestByArray(array $request) : Basicis
    {
        $uri = null;
        if (isset($request['uri'])) {
            $uri = new Uri($request['uri']);
        }

        if ($uri === null) {
            $port = "";
            if (isset($request["port"])) {
                $port = ":".$request["port"];
            }
    
            $query = "";
            if (isset($request["query"])) {
                $query = "?".$request["query"];
            }

            $uri = new Uri(
                sprintf(
                    "%s://%s%s%s%s",
                    $request["protocol"] ?? "http",
                    $request["host"] ?? "localhost",
                    $port,
                    $request["path"] ?? "/",
                    $query
                )
            );
        }

        $serverRequest =  ServerRequestFactory::create($request['method'] ?? "GET", $uri)
                        ->withUploadedFiles($request['files'] ?? [])
                        ->withCookieParams($request['cookie'] ?? []);

        if (isset($request['headers'])) {
            $serverRequest->withHeaders($request['headers']);
        }

        return  $this->setRequest($serverRequest);
    }

    /**
     * Function request
     * Set and/or get current server request of app
     *
     * @return ServerRequestInterface
     */
    public function request(ServerRequestinterface $request = null) : ServerRequestInterface
    {
        if (($request !== null) && ($request instanceof ServerRequestinterface)) {
            $this->setRequest($request);
        }
        return $this->getRequest();
    }


     /**
     * Function setResponse
     * Get current response of app
     *
     * @param  int|null $code
     * @param  string $reasonPhrase
     * @return Basicis
     */
    public function setResponse($code = null, $reasonPhrase = null) : Basicis
    {
        if ($code !== null) {
            $this->response->withStatus($code, $reasonPhrase);
        }
        
        if ($this->response === null) {
            $this->response = ResponseFactory::create($code ?? 200, $reasonPhrase);
        }
        return $this;
    }


    /**
     * Function getResponse
     * Get current response of app
     *
     * @return ResponseInterface
     */
    public function getResponse() : ResponseInterface
    {
        if ($this->response === null) {
            return $this->response = ResponseFactory::create();
        }
        return $this->response;
    }


    /**
     * Function response
     * Set and/or get current server response of app
     *
     * @param  int    $code
     * @param  string $reasonPhrase
     * @return ResponseInterface
     */
    public function response(int $code = null, string $reasonPhrase = null) : ResponseInterface
    {
        if ($code !== null) {
            return $this->setResponse($code, $reasonPhrase)->getResponse();
        }

        return $this->getResponse();
    }


    /**
     * Function getRouter
     * Get the app Router engine instance
     *
     * @return Router
     */
    public function getRouter() : Router
    {
        return $this->router;
    }

    /**
     * Function getRoute
     * Get requested Route on router engine instance according to servervrequest.
     *
     * A ResponseInterface object can be obtained by the getRequest function in the Router instance.
     *
     * @return Route|null
     */
    public function getRoute() : ?Route
    {
        return  $this->route = $this->router->getRoute();
    }


    /**
     * Function setRoute
     * Set a new route in the app router object
     *
     * @param string|array $url "/"
     * @param string|array $method "GET"
     * @param string|ControllerInterface|\Clousure $callback null
     * @param string|array $middlewares null
     * @return Basicis
     */
    public function setRoute($url = "/", $method = "GET", $callback = null, $middlewares = null) : Basicis
    {
        $this->router->setRoute($url, $method, $callback, $middlewares);
        return $this;
    }

     /**
     * Function setRoutesByAnnotations
     * Receives a class as an argument, and works with the comment blocks as @Route
     *
     * @param  string $class
     * @return Basicis
     */
    public function setRoutesByAnnotations(string $class) : Basicis
    {
        if (new $class() instanceof Controller) {
            $annotations = new Annotations($class);
            foreach ($annotations->getClass()->getMethods() as $method) {
                $comment = $annotations->getMethodCommentByTag($method->name, "@Route");
                if ($comment !== null) {
                    $this->router->setRouteByAnnotation($comment, $class.'@'.$method->name);
                }
            }
        }
        return $this;
    }


    /**
     * Function setRoutesByControllers
     * Receives a array of Controller[] with classnames like this '[App\ExampleController, ...]'
     *
     * @param  array|Controller[] $controllers
     * @return Basicis
     */
    public function setRoutesByControllers(array $controllers) : Basicis
    {
        foreach ($controllers as $controller) {
            if (class_exists($controller) && new $controller() instanceof Controller) {
                $this->setRoutesByAnnotations($controller);
            }
        }
        return $this;
    }


    /**
     * Function handleRouterEngining
     * Handles routing engineering performs the specified callback for the route and returns a instance of Basicis
     *
     * @return Basicis
     */
    private function handleRouterEngining() : Basicis
    {
        //Get requested route
        $this->getRoute();

        if ($this->route === null) {
            $this->response->withStatus(
                $this->router->getResponse()->getStatusCode(),
                $this->router->getResponse()->getReasonPhrase()
            );
        }
      
        if ($this->route instanceof Route) {
            //Route middlewares run
            $this->handleRouteMiddlewares($this->route->getMiddlewares());
                
            //Routing and handle Request
            if ($this->response->getStatusCode() >= 200 && $this->response->getStatusCode() <= 206) {
                //Handles Controller or Closure function
                $res = $this->handle($this->request);
                $this->response->withStatus($res->getStatusCode(), $res->getReasonPhrase())
                    ->withBody($res->getBody());
            }
        }
        return $this;
    }


    /**
     * Function auth
     * Get the app Auth/User by authorization token, it is receive a class Basicis\Auth\AuthInterface
     *
     * @param string $authClass
     * @return Auth|null
     */
    public function auth(string $authClass = "Basicis\Auth\Auth") : ?Auth
    {
        if (count($this->request()->getHeader('authorization')) >= 1 && new $authClass instanceof AuthInterface) {
            return $authClass::getUser($this->request()->getHeader('authorization')[0], $this->getAppKey());
        }
        return null;
    }


    /**
     * Function cache
     *
     * Get the app CacheItemPool engine instance
     * @return CacheItemPool
     */
    public function cache() : CacheItemPool
    {
        return $this->cache;
    }


    /**
     * Function write
     * Set a string and status code for write in the http response
     *
     * - Using into controllers or route callback
     *
     *```php
     *   return $app->write("My text with status code default!");
     *   //or
     *   return $app->write("My text with status code 200!", 200);
     * ````
     *
     * @param string $text
     * @param int|null $statusCode
     * @return ResponseInterface
     */
    public function write(string $text = "", int $statusCode = null) : ResponseInterface
    {
        return $this->getResponse()
                ->withStatus($statusCode ?? 200)
                ->withBody((new StreamFactory)->createStream($text));
    }



    /**
     * Function json
     * Set a array data and status code for write in the http response
     *
     * - Using into controllers or route callback
     *
     *```php
     *   return $app->json(["test" => "Test with status code default!"]);
     *   //or
     *   return $app->json(["test" => "Test with status code ok!", "success" => true], 200);
     * ````
     *
     * @param array $data []
     * @param int   $statusCode
     * @return ResponseInterface
     */
    public function json($data = null, int $statusCode = null) : ResponseInterface
    {
        $this->getResponse()
            ->withStatus($statusCode ?? $this->getResponse()->getStatusCode())
            ->withHeader("Content-Type", "application/json; charset=UTF-8");

        $arrayToJson = [
            "meta" => [
                "code" =>  $this->getResponse()->getStatusCode(),
                "message" => $this->getResponse()->getReasonPhrase(),
                "endpoint" => $this->route ? $this->route->getName() : '/',
                "method" => $this->route ? $this->route->getMethod() : 'GET'
            ],
            "data" => $data
        ];

        return $this->write(json_encode($arrayToJson), $this->getResponse()->getStatusCode());
    }


     /**
      * Function view
      * Set a template name, optional data and a optional path for write in the http response.
      *
      * If template especified no not found, a ResponseInterface with status code 404 is returned.
      *
      * - Using into controllers controllers or route callback
      *
      * Starting from the idea that we have a template called `welcome.[html, php or twig]` inside `storage/templates/`
      * or `my-custom/path/`, we have the following code to return this view:
      *
      *```php
      *   return $app->view("welcome", $args = ["test" => "Test ok!"]);
      *   //or
      *    return $app->view("welcome", $args = ["test" => true, "test2" => "Test ok!"], "my-custom/path/");
      * ````
      *
      * - Using into Twig Template file
      * ```
      *   <p>{{test2}}</p>
      *   <p>Var is True: {{test}}</p>
      * ```
      *
      * @param string $name
      * @param array  $data
      * @param string $customPath
      *
      * @return ResponseInterface
      */
    public function view(string $name, array $data = [], $customPath = "") : ResponseInterface
    {
        $content = null;
        if ($this->enableCache && $this->cache->hasItem("template@".$name)) {
            $content = $this->cache->getItem("template@".$name)->get();
        }

        if ($content === null) {
            $view = new View([self::path() . "storage/templates/", self::path() . $customPath]);
            $view->setFilters($this->viewFilters);
            $content = $view->getView($name, $data);

            if ($this->enableCache) {
                $this->cache->addItem("template@".$name, $content, "10 seconds")->commit();
            }
        }
        $statusCode = 200;

        if ($content === null) {
            $content = "Template file '$name' not found!";
            $statusCode = 404;
        }
        return $this->write($content)
                ->withStatus($statusCode)
                ->withHeader("Content-Type", ["text/html", "charset=UTF-8"]);
    }


    /**
     * Function setViewFilters
     * Setting filters functions for use into template
     *
     * - Setting into config/app-config.php file
     *
     * ```php
     *  $app->setViewFilters([
     *     //here, key is required
     *     "isTrue" => function ($value = true) {
     *         return $value;
     *     }
     *  ]);
     * ```
     *
     * - Using into Twig Template file
     *
     * ```
     *   <p>Var is True: {{isTrue($var = true)}}<p>
     * ```
     *
     * or
     *
     * ```
     *   {% if isTrue(var) %}
     *     <p>{{varTextHere}}</p>
     *   {% endif %}
     * ```
     *
     * @param array|TwigFunction[] $filters
     * @return void
     */
    public function setViewFilters(array $filters = []) : Basicis
    {
        foreach ($filters as $key => $filter) {
            if ($filter instanceof \Closure) {
                $this->viewFilters[$key] = new TwigFunction($key, $filter);
            }
        }
        return $this;
    }


    /**
     * Function clientFileDownload
     * Send a file in the body of the http response to the client
     *
     * @param string $filename
     * @param bool $forced false
     *
     * @return ResponseInterface
     */
    public function clientFileDownload(string $filename = null, bool $forced = false) : ResponseInterface
    {
        //If file exists, this no is null
        if ($filename !== null && file_exists($filename)) {
            $file = null;
            $headers = [
                "Content-Type" => \MimeType\MimeType::getType($filename),
                "Content-disposition" => ["filename=".basename($filename)]
            ];

            if ($forced) {
                $headers["Content-disposition"] = array_unshift($headers["Content-disposition"], "attachment");
            }

            if ($this->enableCache && $this->cache->hasItem("file@".$filename)) {
                $file = $this->cache->getItem("file@".$filename)->get();
            }

            if ($file === null) {
                $file = (new StreamFactory())->createStreamFromFile($filename, "r+");
                if ($this->enableCache) {
                    $this->cache->addItem("file@".$filename, $file, "2 minutes")->commit();
                }
            }

            if ($file->isReadable()) {
                return $this->response->withHeaders($headers)->withStatus(200)->withBody($file);
            }

            $file->close();
            return $this->response->withStatus(404, "File not found!");
        }
        return $this->response->withStatus(404, "Invalid filename or file no exists!");
    }



    /**
     * Function clientFileUpload
     * Upload one or more files in the body of the http server request from the client
     *
     * @param UploadedFileInterface $infile
     * @param string $outfile
     *
     * @return array|null
     */
    public function clientFileUpload(UploadedFileInterface $infile, string $outfile = null) : ?array
    {
        if ($infile instanceof UploadedFileInterface) {
            if (!file_exists($outfile) && touch($outfile)) {
                //move file to path
                $infile->moveTo($outfile);
                //reading file in storage
                $outfile = (new StreamFactory())->createStreamFromFile($outfile, "r");

                //Verify if is uploaded
                if ($infile->getSize() === $outfile->getSize()) {
                    $data =  [
                        "name" => str_replace(" ", "", $infile->getClientFilename()),
                        "size" => $infile->getSize(),
                        "type" => $infile->getClientMediaType(),
                    ];
                    $infile->getStream()->close();
                    $outfile->close();
                    return $data;
                }
            }
        }
        return null;
    }



    /**
     * Function controller
     * Instantiate a Basicis\Controller\Controller object and execute the defined method or the standard index method.
     *
     * The key for the controller or class name must be separated from the method name to be executed by `@` or `::`.
     *
     * - Using into outhers controllers or middlewares and defined for Basicis\Basicis::setControllers
     *
     * ```php
     *   $app->controller("example@functionName", $args = [object, array or null]);
     *   //or
     *   $app->controller("Namespace\Example::functionName", $args = [object, array or null]);
     * ````
     *
     * @param string $callback
     * @param string|int|array|object|null $args
     * @return ResponseInterface
     */
    public function controller(string $callback, $args) : ResponseInterface
    {
        if (preg_match("/[a-zA-Z0-9]{1,}@|::[a-zA-Z0-9]{1,}/", $callback)) {
            $callback = str_replace("::", "@", $callback);
            $controller = explode("@", $callback)[0];
            $method = explode("@", $callback)[1] ?? 'index';
            $args = (object) $args;

            try {
                $controllerObj = $this->getController($controller);
                $result = null;
                
                if ($controllerObj instanceof Controller && method_exists($controllerObj, $method)) {
                    $arguments = [];
                    $class = $controllerObj->getModelByAnnotation();
                    $params = (new Annotations($controller))
                                ->setMethod($method)
                                ->getMethod()
                                ->getParameters();
                        
                    foreach ($params as $key => $param) {
                        $type = null;
                        if ($param->getType() !== null) {
                            $type = $param->getType()->getName();
                        }
                        
                        if ($key === 0) {
                            $arguments[$key] = $this;
                        }

                        if ((class_exists($class) && get_parent_class($class) === "Basicis\Model\Model") && $key >= 1) {
                            if (isset($args->id) && $type === "Basicis\Model\Model") {
                                $arguments[$key] = $class::findOneBy(["id" => $args->id]);
                            }

                            if ($type === "Basicis\Model\Models") {
                                $arguments[$key] = new Models($class, (array) $args);
                            }
                        }
                    }

                    $arguments[] = $args;
                    $result = $controllerObj->$method(...$arguments);
                }

                if ($result instanceof ResponseInterface) {
                    return $result;
                }
                return $this->response()->withStatus(200);
            } catch (InvalidArgumentException $e) {
                (new InvalidArgumentException($e->getMessage(), $e->getCode(), $e))->log();
                return $this->getResponse()->withStatus(500, $e->getMessage());
            }
        }

        return $this->getResponse()->withStatus(500);
    }



    /**
     * Function closure
     * Instantiate a Closure object and execute
     *
     * @param \Closure $callback
     * @param string|int|array|object|null $args
     * @return ResponseInterface
     */
    public function closure(\Closure $callback, $args) : ResponseInterface
    {
        if ($callback instanceof \Closure) {
            //Binding $this == $app, $request , $response and $args
            $callback->bindTo(
                (object) [
                    "app" => &$this,
                    "args" => (is_string($args) | is_int($args) ) ? $args : (object) $args
                ]
            );
            
            //Runing $callback function
            $result = $callback($this, (is_string($args) | is_int($args) ) ? $args : (object) $args);
            if ($result instanceof ResponseInterface) {
                return $this->response = $result;
            }

            return $this->getResponse();
        }

        throw new InvalidArgumentException(
            'Expected an instance of \Closure or a with this example:'
            .' function (App $app, $args){}. Optionals params.'
        );
        return $this->getResponse()->withStatus(500);
    }

    
    /**
     * Function input
     * Open a Stream Resource in Read mode and returns its content
     *
     * @param  string $resourceFileName = "php://input"
     * @return void
     */
    public static function input(string $resourceFileName = "php://input"): string
    {
        $content = null;
        if (file_exists($resourceFileName) | $resourceFileName === "php://input") {
            $stream = (new StreamFactory())->createStreamFromFile($resourceFileName, 'r');
            $content = $stream->getContents();
            $stream->close();
        }
        return $content ?? '';
    }


    /**
     * Function output
     * Open a Stream Resource in Recording mode and write a text in it, sending headers
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @param  string $resourceFileName
     * @return integer
     */
    public static function output(
        ServerRequestInterface $request,
        ResponseInterface $response,
        string $resourceFileName = "php://output"
    ) : int {
        if (!file_exists($resourceFileName) && $resourceFileName !== "php://output") {
            touch($resourceFileName);
        }

        if (file_exists($resourceFileName) | $resourceFileName === "php://output") {
            $stream = (new StreamFactory())->createStreamFromFile($resourceFileName, 'rw');
            $size = 0;

            if ($stream->isWritable()) {
                header(
                    sprintf(
                        '%s/%s %s %s',
                        strtoupper($request->getUri()->getScheme()),
                        $response->getProtocolVersion(),
                        $response->getStatusCode(),
                        $response->getReasonPhrase()
                    ),
                    true
                );
    
                foreach ($response->getHeaders() as $name => $value) {
                    header($response->getHeaderLine($name), true);
                }
                $size = $stream->write($response->getBody());
                $response->getBody()->close();
            }

            $stream->close();
            return $size;
        }
        return 0;
    }


    /**
     * Function handleError
     * Returns a template view with errors occurred during the execution of the application according to http response
     *
     * @param string $message
     *
     * @return Basicis
     */
    public function handleError(string $message = null) : Basicis
    {
        $this->view("error", [
            "message" => $message ?? sprintf(
                "%s - %s",
                $this->response->getStatusCode(),
                $this->response->getReasonPhrase()
            )
        ]);
        return $this;
    }
   
    /**
     * Function extractData
     * Extract data on ServerRequest and/or Route url params
     *
     * @param ServerRequestInterface $request
     * @param Route $route
     *
     * @return array
     */
    public static function extractData(ServerRequestInterface $request = null, Route $route = null) : array
    {
        $args = [];
        if ($route !== null) {
            $args = (array) $route->getArguments();
        }

        if ($request !== null && $request->getParsedBody() !== null) {
            $args = array_merge((array) $request->getParsedBody(), (array) $args);
        }
        return $args;
    }

    /**
     * handle function
     * Handles the callback function returned by routing engineering and executes it, this return a ResponseInterface
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        //Mergin Route arguments and ServerRequest data, files, cookies...
        $args = (object) self::extractData($request, $this->route);

        //get callback Closure
        $callback = $this->route->getCallback();
        if ($callback instanceof \Closure) {
            try {
                return $this->closure($callback, $args);
            } catch (InvalidArgumentException $e) {
                (new InvalidArgumentException($e->getMessage(), $e->getCode(), $e))->log();
            }
        }

        //get callback String Controller
        $callback = $this->route->getCallbackString();
        if (preg_match("/[a-zA-Z0-9]{1,}[@|::]{1,}[a-zA-Z0-9]{0,}/", $callback)) {
            try {
                return $this->controller($callback, $args);
            } catch (InvalidArgumentException $e) {
                (new InvalidArgumentException($e->getMessage(), $e->getCode(), $e))->log();
            }
        }

        return $this->response(500);
    }

    /**
     * Function redirect
     * Redirect a Server Request with url, method and optional array of data
     *
     * @param string $url
     * @param string $method
     * @param array $data
     *
     * @return ResponseInterface
     */
    public function redirect(string $url = "/", $method = "GET", array $data = null) : ResponseInterface
    {
        if (isset($data) && $this->getRequest()->getParsedBody() !== null) {
            $data = array_merge($data, $this->getRequest()->getParsedBody());
        }
        
        $this->setRequest(ServerRequestFactory::create($method, $url))
            ->getRequest()->withParsedBody($data ?? []);

        return $this->handleRouterEngining()->getResponse()->withStatus(307);
    }

    /**
     * Function runAndResponse
     * Run app pipe line and return a instance of ResponseInterface
     *
     * @return ResponseInterface
     */
    public function runAndResponse() : ResponseInterface
    {
        //Get request body
        $this->request->withParsedBody(self::input($this->getResourceInput()));
        //Before middlewares and Router Engining
        $this->handleBeforeMiddlewares();
        //Router Engining
        $this->handleRouterEngining();
        //After middlewares
        $this->handleAfterMiddlewares();
        
        //If errors occurred during the execution of the application according to http response
        if ($this->response->getStatusCode() > 307) {
            $this->handleError();
        }
        return $this->response;
    }

     /**
     * Function run
     * Finally execute the app instance passed as parameters to standard input and output for php application.
     *
     * By definition the values ​​are respectively "php://input" for input and "php://output" for output.
     *
     * @param string $inputResource = "php://input"
     * @param string $outputResource = "php://output"
     * @return int
     */
    public function run() : int
    {
        //Run app pipe line and return a instance of ResponseInterface
        $response = $this->runAndResponse();
        return self::output($this->request, $response, $this->getResourceOutput());
    }
}
