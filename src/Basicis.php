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
use Basicis\Http\Server\RequestHandlerInterface;
use Basicis\Http\Message\Response;
use Basicis\Http\Message\Uri;
use Basicis\Http\Message\ServerRequestFactory;
use Basicis\Http\Message\ResponseFactory;
use Basicis\Http\Message\StreamFactory;
use Basicis\Controller\Controller;
use Basicis\Controller\ControllerInterface;
use Basicis\Http\Server\Middleware;
use Basicis\Http\Server\MiddlewareInterface;
use Basicis\Http\Server\PipeLine;
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
class Basicis implements RequestHandlerInterface
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
    
    private $options = [];

    private $pipeLine;


    /**
     * Function __construct
     * Construct a instanceof Basicis\Basicis lovingly named $app
     *
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        if (in_array($request->getAttribute("appEnv", "dev"), ["development", "dev"])) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
        
        date_default_timezone_set(
            $request->getAttribute(
                "appTimezone",
                date_default_timezone_get()
            )
        );
        
        $this->enableCache($request->getAttribute("appCache", false));

        $this->router = new Router();
        $this->setRequest($request);
    }

    /**
     * Function createApp Factory
     * Create a instanceof Basicis\Basicis and return it is
     *
     * @param  ServerRequestInterface|array $request
     * @return Basicis
     */
    public static function createApp($request = null) : Basicis
    {
        $serverRequest = ServerRequestFactory::create('GET', '/');
        if ($request instanceof ServerRequestInterface) {
            $serverRequest = $request;
        }
    
        if (is_array($request)) {
            $serverRequest = ServerRequestFactory::createFromArray(array_merge($request));
        }
        return new Basicis($serverRequest);
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

            if ($this->cacheIsEnabled()) {
                $this->cache()->addItem("controllers", $controllers, "2 minutes")->commit();
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
        foreach ($this->controllers as $key => $class) {
            if ($class === $arg | $key === $arg) {
                return new $class();
            }
        }
        throw new InvalidArgumentException("Unidentified or Invalid argument to be get Controller instance.");
        return null;
    }

    /**
     * Function extractCallbackToArray
     * Extract and return a array with controller name/class and method or null
     * @param string $callback
     *
     * @return array|null
     */
    public function extractCallbackToArray(string $callback) : ?array
    {
        if (preg_match("/[a-zA-Z0-9]{1,}@|::[a-zA-Z0-9]{1,}/", $callback)) {
            $callback = str_replace("::", "@", $callback);
            return [
                "controller" => explode("@", $callback)[0],
                "method" => explode("@", $callback)[1] ?? 'index'
            ];
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
        $filtedsMiddlewares = [];
        foreach ($middlewares as $key => $middleware) {
            $middlewareObj = null;
            if (is_string($middleware) && (new $middleware() instanceof MiddlewareInterface)) {
                $middlewareObj = new $middleware();
            }

            if ($middlewareObj === null && ($middleware instanceof MiddlewareInterface)) {
                $middlewareObj = $middleware;
            }

            if ($requireKey && is_string($key) && !empty($key)) {
                $filtedsMiddlewares[$key] = $middlewareObj;
            }
            
            if ($requireKey && !is_string($key) | empty($key)) {
                throw new InvalidArgumentException(
                    "Unidentified key or Psr\Http\Server\MiddlewareInterface instance."
                );
                unset($filtedsMiddlewares[$key]);
            }

            if (!$requireKey) {
                $filtedsMiddlewares[] = $middlewareObj;
            }
        }
        return $filtedsMiddlewares;
    }

    /**
     * Function setRouteMiddlewares
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
        } catch (\Exception $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
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
        } catch (\Exception $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
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
        } catch (\Exception $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
        return $this;
    }

    /**
     * Function setMiddlewares
     * Set all middlewares for the app at once
     *
     * - Setting into config/app-config.php file
     *
     * ```php
     *  $app->setMiddlewares(
     *      [
     *          //key no is required
     *          "App\\Middlewares\\BeforeExample",
     *          //...
     *      ],
     *      [
     *          //only here, key is required
     *          "guest" => "App\\Middlewares\\Guest",
     *          "auth" => "App\\Middlewares\\Auth",
     *          "example" => "App\\Middlewares\\Example",
     *          //...
     *      ],
     *      [
     *         //key no is required
     *         "App\\Middlewares\\AfterExample",
     *         //...
     *      ]
     *  );
     * ```
     *
     */
    public function setMiddlewares(array $before = [], array $route = [], array $after = []) : Basicis
    {
        try {
            $this->setBeforeMiddlewares($before)
            ->setRouteMiddlewares($route)
            ->setAfterMiddlewares($after);
        } catch (\Exception $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
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
     * Handles middleware prior to the route and executes it, this return a ResponseInterface
     *
     * @return ResponseInterface
     */
    private function handleBeforeMiddlewares() : PipeLine
    {
        return Middleware::pipeLine($this->getMiddlewares("before"));
    }

    /**
     * Function middlewaresHandle
     * Handles route middleware and executes it, this return a PipeLine
     *
     * @return \Closure
     */
    private function handleRouteMiddlewares() : \Closure
    {
        //Handle all middlewares
        $app = $this;
        return function ($request, $response, $next = null) use ($app) {
            $pipeLineArray = [];

            if ($request->getAttribute('route', null) instanceof Route) {
                foreach ($request->getAttribute("route")->getMiddlewares() as $middleware) {
                    if (array_key_exists($middleware, $app->getMiddlewares("route"))) {
                        $pipeLineArray[] = $app->getMiddlewares("route")[$middleware];
                    }
                }
            }

            $pipeLine = Middleware::pipeLine($pipeLineArray);
            return $pipeLine($request, $response, $next);
        };
    }

    /**
     * Function handleAfterMiddlewares
     * Handles middleware after the route and executes it, this return a instance of PipeLine
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return PipeLine
     */
    private function handleAfterMiddlewares() : PipeLine
    {
        //After middlewares here
        return Middleware::pipeLine($this->getMiddlewares("after"));
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
     * Function getDescription
     * Getting App description string
     *
     * @param string $descriptionDefault
     *
     * @return String
     */
    public function getDescription() : String
    {
        return $this->getRequest()->getAttribute("appDescription", "This is a Basicis framework App!");
    }

    /**
     * Function cache
     *
     * Get the app CacheItemPool engine instance
     * @return CacheItemPool|null
     */
    public function cache() : ?CacheItemPool
    {
        if ($this->cacheIsEnabled() && ($this->cache instanceof CacheItemPool)) {
            return $this->cache;
        }
        return null;
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
    public function enableCache(bool $enable = true, string $cacheFile = "cache/app")  : Basicis
    {
        if ($enable) {
            $this->cache = new CacheItemPool(self::path().$cacheFile);
        }
        $this->getRequest()->withAttribute("appCache", $enable);
        return $this;
    }

    /**
     * Function cacheIsEnabled
     * Check if app cache is enabled and return boolean
     *
     * @return boolean
     */
    public function cacheIsEnabled() : bool
    {
        return $this->getRequest()->getAttribute("appCache", false);
    }

    /**
     * Function getRequest
     * Get current server request of app
     *
     * @return ServerRequestInterface
     */
    public function getRequest() : ServerRequestInterface
    {
        if ($this->request === null) {
            $this->setRequest(ServerRequestFactory::create("GET", "/"));
        }
        return $this->request;
    }

    /**
     * Function setRequest
     * Set current server request of app
     *
     * @param ServerRequestInterface $request
     * @return Basicis
     */
    public function setRequest(ServerRequestInterface $request) : Basicis
    {
        $this->request = $request->withParsedBody(self::input($this->getResourceInput()));
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
    public function request(ServerRequestInterface $request = null) : ServerRequestInterface
    {
        if (($request !== null) && ($request instanceof ServerRequestInterface)) {
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
        $this->response = $this->getResponse()
            ->withStatus(
                $code ?? $this->getResponse()->getStatusCode(),
                $reasonPhrase
            )
            ->withHeader(
                "",
                sprintf(
                    '%s/%s %s %s',
                    strtoupper($this->getRequest()->getUri()->getScheme()),
                    $this->getRequest()->getProtocolVersion(),
                    $this->getResponse()->getStatusCode(),
                    $this->getResponse()->getReasonPhrase()
                )
            );
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
            return $this->response = (ResponseFactory::create())->withHeader("X-Powered-By", $this->getDescription());
        }
        return $this->response;
    }

    /**
     * Function response
     * Set and/or get current server response of app
     *
     * @param  int|ResponseInterface $code
     * @param  string $reasonPhrase
     * @return ResponseInterface
     */
    public function response($code = null, string $reasonPhrase = null) : ResponseInterface
    {
        if ($code !== null && is_int($code)) {
            return $this->setResponse($code, $reasonPhrase)->getResponse();
        }
        if ($code !== null && $code instanceof ResponseInterface) {
            return $this->response = $code;
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
        if ($this->router === null) {
            return $this->router = RouterFactory::create();
        }
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
        return $this->route = $this->router->setRequest($this->getRequest())->getRoute();
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
     * Function auth
     * Get the app Auth/User by authorization token, it is receive a class Basicis\Auth\AuthInterface
     *
     * @param string $authClass
     * @return Auth|null
     */
    public function auth() : ?Auth
    {
        foreach ($this->getRequest()->getAttributes() as $key => $attribute) {
            if ($attribute instanceof AuthInterface) {
                return $attribute;
            }
        }
        return null;
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
        $arrayToJson = [
            "meta" => [
                "code" =>  $this->response($statusCode)->getStatusCode(),
                "message" => $this->response()->getReasonPhrase(),
                "endpoint" => $this->request()->getUri(),
                "method" => $this->request()->getMethod()
            ],
            "data" => $data
        ];

        return $this->write(json_encode($arrayToJson))
                    ->withStatus($statusCode ?? $this->response()->getStatusCode())
                    ->withHeader("Content-Type", "application/json; charset=UTF-8");
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
        if ($this->cacheIsEnabled() && $this->cache()->hasItem("template@".$name)) {
            $content = $this->cache()->getItem("template@".$name)->get();
        }

        if ($content === null) {
            $view = new View([self::path() . "storage/templates/", self::path() . $customPath]);
            $view->setFilters($this->viewFilters);
            $content = $view->getView($name, $data);

            if ($this->cacheIsEnabled()) {
                $this->cache()->addItem("template@".$name, $content, "10 seconds")->commit();
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
     * Function error
     * Return a view error reporting html or json
     * @param int $code
     * @param string $message
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function error(int $code, string $message = null) : ResponseInterface
    {
        $response = ResponseFactory::create($code, $message);
        $conteType = $response->getHeaderLine("Content-Type");
        if (str_starts_with($conteType, "text/html") | $conteType === "") {
            return $this->view(
                "error",
                [
                    "message" => sprintf(
                        "%s | %s",
                        $code,
                        $message
                    )
                ]
            )->withStatus($code, $message);
        }

        if (str_starts_with($conteType, "application/json")) {
            return $this->json([
                "error" => [
                    "code" => $code,
                    "message" => $message
                ]
            ])->withStatus($code, $message);
        }
        return $response->withStatus($code, $message);
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

            if ($this->cacheIsEnabled() && $this->cache()->hasItem("file@".$filename)) {
                $file = $this->cache()->getItem("file@".$filename)->get();
            }

            if ($file === null) {
                $file = (new StreamFactory())->createStreamFromFile($filename, "r+");
                if ($this->cacheIsEnabled()) {
                    $this->cache()->addItem("file@".$filename, $file, "2 minutes")->commit();
                }
            }

            if ($file->isReadable()) {
                return $this->getResponse()->withHeaders($headers)->withStatus(200)->withBody($file);
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
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param string $callback
     *
     * @return ResponseInterface
     */
    public function controller(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) : ResponseInterface {
        $route = $request->getAttribute("route");

        if ($route instanceof Route && is_string($route->getCallback())) {
            $callback = $this->extractCallbackToArray($route->getCallback());
            $controller = $this->getController($callback["controller"]);
            try {
                if ($controller instanceof Controller &&
                    method_exists($controller, $callback["method"])
                ) {
                    $request->withAttribute("action", $callback["method"])
                            ->withAttribute("app", $this);
                    return $controller($request, $response, $next);
                }
            } catch (InvalidArgumentException $e) {
                throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
                return $response->withStatus(500, $e->getMessage());
            }
        }

        return  $response->withStatus(500);
    }

    /**
     * Function closure
     * Instantiate a Closure object and execute
     *
     * @param \Closure $callback
     * @param string|int|array|object|null $args
     * @return ResponseInterface
     */
    public function closure(
        \Closure $callback,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : ResponseInterface {
        if ($callback instanceof \Closure) {
            //Binding $app, $request and $response
            $callback->bindTo(
                (object) [
                    "app" => &$this,
                    "request" => $request,
                    "response" => $response
                ]
            );
            
            //Runing $callback function
            $result = $callback($this, $request, $response);
            if ($result instanceof ResponseInterface) {
                return $result;
            }
        }

        throw new InvalidArgumentException(
            'Expected an instance of \Closure or a with this example:'
            .' function (App $app, ServerRequestInterface $request, ResponseInterface $response){}. Optionals params.',
            0
        );
        return $response->withStatus(500);
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
     * @param  ResponseInterface $response
     * @param  string $resourceFileName
     * @return int size of stream writed content or "0"
     */
    public static function output(
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
                header($response->getHeaderLine(""), true);
                $response->withoutHeader("");

                foreach ($response->getHeaderLines() as $line) {
                    header($response->getHeaderLine($line), true);
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
      * @param string $name
      * @return ResponseInterface
      */
    public function handleError(string $message = null) : \Closure
    {
        $app = $this;
        return function ($request, $response, $next = null) use ($app) {
            if ($response->getStatusCode() > 307) {
                return $this->error(
                    $response->getStatusCode(),
                    $message ?? $response->getReasonPhrase()
                );
            }

            if ($next === null) {
                return $response;
            }
            return $next($request, $response);
        };
    }
   
    /**
      * handle function
      * Handles the callback function returned by routing engineering and executes it, this return a ResponseInterface
      *
      * @param ServerRequestInterface $request
      * @param ResponseInterface $response
      * @param callable $next
      *
      * @return ResponseInterface
      * @throws InvalidArgumentException
      */
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) : ResponseInterface {
        $route = $request->getAttribute("route");
        if ($route instanceof Route) {
            //get callback Closure
            $callback = $route->getCallback();
            if ($callback instanceof \Closure) {
                try {
                    $response =  $this->closure($callback, $request, $response);
                } catch (\Exception $e) {
                    throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
                }
            }

            if (is_string($callback)) {
                try {
                    $response = $this->controller($request, $response);
                } catch (\Exception $e) {
                    throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
                }
            }
        }

        if ($next === null) {
            return $response;
        }
        return $next($request, $response);
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
    public function redirect(string $url = "/", $method = "GET", array $data = []) : ResponseInterface
    {
        return $this->pipeLine(
            $this->getRequest()->withMethod($method)->withRequestTarget($url)
            ->withParsedBody(array_merge($data, $this->getRequest()->getParsedBody() ?? [])),
            $this->getResponse()
        )->withStatus(307);
    }

    /**
      * Function pipeLine
      * Run set and middlewares levels pipeline and return a instanceof ResponseInterface
      *
      * @param ServerRequestInterface $request
      * @param ResponseInterface|null $response
      * @param callable $next
      *
      * @return ResponseInterface
      */
    public function pipeLine(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : ResponseInterface {
        //Start app pipeline with
        $pipeLine = new PipeLine();
        
        //Add handler before middlewares
        $pipeLine->add($this->handleBeforeMiddlewares());
        //Add handler Router Engining
        $pipeLine->add($this->getRouter());
        //Add handler router middlewares
        $pipeLine->add($this->handleRouteMiddlewares());

        $response = $pipeLine($request, $response);
        $pipeLine->reset();

        if ($response->getStatusCode() >= 200 && $response->getStatusCode() <= 307) {
            //Add handler app core
            $pipeLine->add($this);
        }
     
        //Add handler after middlewares
        $pipeLine->add($this->handleAfterMiddlewares());
        //Handle errors if it`s exists
        $pipeLine->add($this->handleError());

        //Return a instanceo of PipeLine
        return $pipeLine($request, $response)->withHeader(
            "",
            sprintf(
                "%s/%s %s %s",
                strtoupper($request->getUri()->getScheme()),
                $request->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            )
        );
    }

    /**
     * Function runAndResponse
     * Run app pipe line and return a instance of ResponseInterface
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) : ResponseInterface {
        $this->request($request);
        $this->response($response);
        $request->withAttribute("app", $this);

        //Run pipeline and return a instanceo of ResponseInterface
        return $this->handle($request, $response, $next);
    }

    /**
     * Function run
     * Finally execute the app instance passed as parameters to standard input and output for php application.
     *
     * By definition the values ​​are respectively "php://input" for input and "php://output" for output.
     *
     * @param string $inputResource "php://input"
     * @param string $outputResource "php://output"
     * @return int
     */
    public function run() : int
    {
        //Run app pipe line and return a instance of ResponseInterface
        $response = $this->pipeLine(
            $this->getRequest()->withParsedBody(self::input($this->getResourceInput())),
            $this->getResponse()
        );
    
        //Return user output by is default php://output
        return self::output($response, $this->getResourceOutput());
    }
}
