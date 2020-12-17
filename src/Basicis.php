<?php
namespace Basicis;

use Basicis\Core\Log;
use Basicis\Core\Validator;
use Basicis\Core\Annotations;
use Basicis\Router\RouterFactory;
use Basicis\Router\Router;
use Basicis\Router\Route;
use Basicis\View\View;
use Basicis\Http\Message\ServerRequest;
use Basicis\Http\Server\RequestHandler;
use Basicis\Http\Message\Response;
use Basicis\Http\Message\ServerRequestFactory;
use Basicis\Http\Message\ResponseFactory;
use Basicis\Http\Message\StreamFactory;
use Basicis\Controller\Controller;
use Basicis\Http\Server\Middleware;
use Basicis\Exceptions\InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Twig\TwigFunction;
use Dotenv\Dotenv;
use \Mimey\MimeTypes;

/**
 * Basicis - App
 *
 * Main class Basicis framework
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
     * const DEFAULT_ENV = [
     *   "APP_ENV" => "dev",
     *   "APP_TIMEZONE" =>  "America/Recife",
     *   "APP_PATH" => null
     *  ];
     *
     * Default app enviroments variables values
     */
    const DEFAULT_ENV = [
        "APP_ENV" => "dev",
        "APP_TIMEZONE" =>  "America/Recife",
        "APP_PATH" => null
    ];

    /**
    * $mode variable
    *
    * @var String
    */
    private $mode = self::DEFAULT_ENV["APP_ENV"];

    /**
    * $timezone variable
    *
    * @var String
    */
    private $timezone = self::DEFAULT_ENV["APP_TIMEZONE"];

    /**
    * $path variable
    *
    * @var String
    */
    private static $path = self::DEFAULT_ENV["APP_PATH"];

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
     * Function __construct
     *
     * @param ServerRequestInterface $request
     * @param array ...$options
     */
    public function __construct(ServerRequestInterface $request, array ...$options)
    {
        $this->router  = 
        $this->setMode($options['mode'] ?? 'dev');
        $this->setTimezone($options['timezone'] ?? 'America/Recife');
        $this->setRequest($request);
        $this->response = (ResponseFactory::create())->withHeader("X-Powered-By", $options['appDescription'] ?? "Basicis Framework!");
    }



    /**
     * Function createApp Factory
     *
     * @param ServerRequestInterface $request
     * @param array ...$options
     * @return Basicis
     */
    public static function createApp(ServerRequestInterface $request = null, array ...$options) : Basicis
    {
        self::loadEnv();
        return new Basicis($request ?? ServerRequestFactory::create('GET', '/'), $options);
    }

   

    /**
     * Function setControllers
     *
     * @param array $controllers
     *
     * @return Basicis
     */
    public function setControllers(array $controllers = []) : Basicis
    {
        foreach ($controllers as $key => $value) {
            $class = $value;
            if ($value instanceof controller) {
                $class = get_class($value);
                $controllers[$key] = get_class($value);
            } 

            if (class_exists($class)) {
                $this->setRoutesByAnnotations($class);
            }

            if (!is_string($key) || !class_exists($class) | !(new $value() instanceof Controller)) {
                throw new InvalidArgumentException("Unidentified key or class Basicis\Controller\Controller instance.");
                unset($controllers[$key]);
            }
        }
        
        $this->setRoutesByControllers($this->controllers = $controllers);
        return $this;
    }



    /**
     * Function getController
     *
     * @param string $arg [keyname|class]
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
     * Undocumented function
     *
     * @param array $middlewares
     * @param boolean $requireKey = false
     *  If A middleware key must be defined
     *
     * @return array
     */
    private function filterMiddlewares(array $middlewares = [], $requireKey = false) : array
    {
        foreach ($middlewares as $key => $middleware) {
            if (($requireKey && !is_string($key)) | !(new $middleware() instanceof Middleware)) {
                throw new InvalidArgumentException("Unidentified key or Basicis\Http\Server\Middleware instance.");
                unset($middlewares[$key]);
            }
        }
        return $middlewares;
    }


    /**
     * Function setMiddlewares
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
        }
        return $this;
    }


    /**
     * Function setBeforeMiddlewares
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
        }
        return $this;
    }


    /**
     * Function setAfterMiddlewares
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
        }
        return $this;
    }


    /**
     * Function setViewFilters
     *
     * @param array|TwigFunction[] $filters
     *
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
     * Function getMiddlewares
     *
     * @param string $type ['before'|'route'|'after'|null]
     * Return an arra with especified middlewares type or all if no is especified the $type argument
     * 
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
     * Function path
     * Return app project root path
     * @return string
     */
    // To-do remove
    public static function path() : string
    {
        $path = sprintf("%s/", getcwd());
        $i = 0;

        while ($i < 3) {
            $command = exec('ls '.$path);
            if ((strpos($command, 'vendor')  >= 0) && (strpos($command, 'vendor') !== false)) {
                break;
            }
            $path .= '../';
            $i++;
        }

        if (!preg_match("/\/$/", $path)) {
            $path .= "/";
        }

        return $path;
    }


    /**
     * Function logger
     *
     * @return Log
     */
    // To-do remove
    public static function logger() : Log
    {
        return new Log(self::path());
    }



    /**
     * Function env
     *
     * @return boolean
     */
    // To-do remove
    public static function loadEnv() : bool
    {
        try {
            $env = Dotenv::createImmutable(self::path());
            $env->load();
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

     /**
     * Function env
     *
     * @param string $name
     * @return string|null
     */
    // To-do remove
    public static function getEnv(string $name) : ?string
    {
        self::loadEnv();
        $env = \getenv($name);
        if ($env !== null) {
            return $env;
        }
        return null;
    }


    /**
     * Function validate
     *
     * @param string|array $data
     * @param string|array $validations
     * @param string $class
     * @return boolean
     */
    // To-do remove
    public static function validate($data, $validations, $class = '') : bool
    {
        return Validator::validate($data, $validations, $class);
    }


    /**
     * Function setMode
     * Setting App operation Mode, development ["dev"|null] ou production ["production"|"prod"]
     *
     * @param string $mode = ["dev"|"production"|"prod"|null]
     * Default value "dev" == Development Mode
     *
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
     * Function setRequest
     *
     * @param ServerRequestinterface $request
     *
     * @return Basicis
     */
    public function setRequest(ServerRequestinterface $request) : Basicis
    {
        $this->router = RouterFactory::create($this->request = $request);
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
     * Function setTimezone
     * Setting app timezone, default America/Recife
     *
     * @param string $timezone
     *
     * @return Basicis
     */
    public function setTimezone(string $timezone = null) : Basicis
    {   
        $this->timezone = isset($timezone) ? $timezone : self::DEFAULT_ENV['APP_TIMEZONE'];
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
     *
     * @return ServerRequestInterface
     */
    public function getRequest() : ServerRequestInterface
    {
        return $this->request;
    }


    /**
     * Function request
     * Alias for getRequest
     *
     * @return ServerRequestInterface
     */
    public function request() : ServerRequestInterface
    {
        return $this->getRequest();
    }


    /**
     * Function getResponse
     *
     * @param int $code
     * @param  string $reasonPhrase
     * @return ResponseInterface
     */
    public function getResponse(int $code = null, string $reasonPhrase = null) : ResponseInterface
    {
        return ($code !== null) ? $this->response->withStatus($code) : $this->response;
    }


    /**
     * Function response
     * Alias for getResponse
     *
     * @param int $code
     * @param  string $reasonPhrase
     * @return ResponseInterface
     */
    public function response(int $code = null, string $reasonPhrase = null) : ResponseInterface
    {
        return $this->getResponse($code, $reasonPhrase);
    }


    /**
     * Function getRouter
     *
     * @return Router
     */
    public function getRouter() : Router
    {
        return $this->router;
    }


    /**
     * Function getRoute
     *
     * @return Route|null
     */
    public function getRoute() : ?Route
    {
        return $this->router->getRoute();
    }


    /**
     * Function setRoutesByAnnotations
     * Receives a class as an argument, and works with the comment blocks as @Route
     * 
     * @param string $class
     * @return Basicis
     */
    public function setRoutesByAnnotations(string $class) : Basicis
    {
        if (new $class() instanceof Controller) {
            $annotations = new Annotations($class);
            foreach($annotations->getClass()->getMethods() as $method) {
                $comment = $annotations->getCommentByTag($method->name, "@Route");
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
     * @param array|Controller[] $controllers
     * @return Basicis
     */
    public function setRoutesByControllers(array $controllers) : Basicis
    {
        foreach ($controllers as $controller) {
            if (new $controller() instanceof Controller) {
                $this->setRoutesByAnnotations($controller);
            }
        }
        return $this;
    }



    /**
     * Function get
     *
     * @param string $url
     * @param string|\Closure $callback
     * @param string|array $middlewares
     * @return void
     */
    public function get(string $url = "/", $callback = null, $middlewares = null)
    {
        $this->router->setRoute("GET", $url, $callback, $middlewares);
        return $this;
    }



    /**
     * Function post
     *
     * @param string $url
     * @param string|\Closure $callback
     * @param string|array $middlewares
     * @return void
     */
    public function post(string $url, $callback = null, $middlewares = null)
    {
        $this->router->setRoute("POST", $url, $callback, $middlewares);
        return $this;
    }



    /**
     * Function put
     *
     * @param string $url
     * @param string|\Closure $callback
     * @param string|array $middlewares
     * @return void
     */
    public function put(string $url, $callback = null, $middlewares = null)
    {
        $this->router->setRoute("GET", $url, $callback, $middlewares);
        return $this;
    }



    /**
     * Function patch
     *
     * @param string $url
     * @param string|\Closure $callback
     * @param string|array $middlewares
     * @return void
     */
    public function patch(string $url, $callback = null, $middlewares = null)
    {
        $this->router->setRoute("PATCH", $url, $callback, $middlewares);
        return $this;
    }



    /**
     * Function detete
     *
     * @param string $url
     * @param string|\Closure $callback
     * @param string|array $middlewares
     * @return void
     */
    public function delete(string $url, $callback = null, $middlewares = null)
    {
        $this->router->setRoute("DELETE", $url, $callback, $middlewares);
        return $this;
    }





    /**
     * Function write
     *
     * @param string $text
     * @param int $statusCode default=200
     *
     * @return ResponseInterface
     */
    public function write(string $text = "", int $statusCode = null) : ResponseInterface
    {
        $stream = (new StreamFactory)->createStream($text); 
        $this->response->withBody($stream);
        return $this->response->withStatus($statusCode === null ? 200 : $statusCode);
    }



    /**
     * Function json
     *
     * @param array $data = []
     * @param int $statusCode = 200
     *
     * @return ResponseInterface
     */
    public function json($data = [], int $statusCode = 200) : ResponseInterface
    {
        $this->response()->withHeader("Content-Type", "application/json; charset=UTF-8")
                       ->withStatus($statusCode);
        $data = [
            "BasicisAPI" => [
                "meta" => [
                    "code" => $this->response()->getStatusCode(),
                    "message" => $this->response()->getReasonPhrase(),
                    "endpoint" => $this->route ? $this->route->getName() : '/'
                ],
                "data" => $data
            ]
        ];
        return $this->write(json_encode($data));
    }


     /**
     * Function view
     *
     * @param string $name
     * @param array $data
     * @param int $statusCode default=200
     * @param string $customPath
     *
     * @return ResponseInterface
     */
    public function view(string $name, array $data = [], int $statusCode = 200, $customPath = "") : ResponseInterface
    {
        $view = new View(
                [
                    self::path() . "storage/templates/",
                    self::path() . $customPath,
                ]
            );
        $view->setFilters($this->viewFilters);
        $this->response->withHeader("Content-Type", ["text/html", "charset=UTF-8"])
                         ->withStatus($statusCode);

        $content = $view->getView($name, $data);
        if ($content !== null) {
            return $this->write($content);
        }

        return $this->write("Template file '$name' not found!", 404); //temp
    }


    /**
     * Function clientFileDownload
     *
     * @param string $filename
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function clientFileDownload(string $filename = null) : ResponseInterface
    {
        //If file exists, this no is null
        if ($filename !== null) {
            $file = (new StreamFactory())->createStreamFromFile($filename, "r+");
            if ($file->isReadable()) {
                return $this->response->withHeaders(
                        [
                            "Content-Type" => \MimeType\MimeType::getType($filename),
                            "Content-disposition" => ["attachment", "filename=".basename($filename)]
                        ]
                    )
                    ->withBody($file)
                    ->withStatus(200, "Ok, working as expected!");
            }

            return $this->response->withStatus(404, "File not found!");
        }

        return $this->response->withStatus(500, "Development error, Filename must not be null.");
    }



    /**
     * Function clientFileupload
     *
     * @param UploadedFileInterface $infile
     * @param string $outfile
     *
     * @return array|null
     */
    public function clientFileupload(UploadedFileInterface $infile, string $outfile = null) : ?array
    {
        if ($infile instanceof UploadedFileInterface) {
            //move file to path
            $infile->moveTo($outfile);

            //reading file in storage
            $outfile = (new StreamFactory())->createStreamFromFile($outfile, "r+");

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
        return null;
    }



    /**
     * Function controller
     *
     * @param string $callback
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function controller(string $callback, $args) : ResponseInterface
    {
        if (preg_match("/[a-zA-Z0-9]{1,}@|::[a-zA-Z0-9]{1,}/", $callback)) {
            $callback = str_replace("::", "@", $callback);
            $controller = explode("@", $callback)[0];
            $method = explode("@", $callback)[1] ?? 'index';
    
            try {
                $controllerObj = $this->getController($controller);

                if ($controllerObj instanceof Controller && method_exists($controllerObj, $method)) {
                    $result = $controllerObj->$method($this, (object) $args);
                    if ($result instanceof ResponseInterface) {
                        return $this->response = $result;
                    }
                    
                    return $this->response()->withStatus(200);
                }
            } catch (InvalidArgumentException $e) {
                throw $e;
            }
        }

        return $this->response()->withStatus(500);
    }



    /**
     * Function closure
     *
     * @param \Closure $callback
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function closure(\Closure $callback, $args) : ResponseInterface
    {
        if ($callback instanceof \Closure) {
            //Binding $this == $app, $request , $response and $args
            $callback->bindTo((object) [
                "app" => &$this,
                "args" => $args
            ]);
            
            //Runing $callback function
            $result = $callback($this, (object) $args);
            if ($result instanceof ResponseInterface) {
                return $this->response = $result;
            }

            return $this->response();
        }

        throw new InvalidArgumentException(
            'Expected an instance of \Closure or a with this example:'
            .' function(App $app, $args){}. Optionals params.'
        );
        return $this->response()->withStatus(500);
    }

    
    /**
     * Function input
     * Opens a Stream Resource in Read mode and returns its content
     * @param string $resourceFileName = "php://input"
     * @return void
     */
    public static function input(string $resourceFileName = "php://input"): string
    {
        //Opening input stream
        $stream = (new StreamFactory())->createStreamFromFile($resourceFileName, 'r');
        $content = $stream->getContents();
        $stream->close();
        return $content ?? '';
    }


    /**
     * Function output
     * Open a Stream Resource in Recording mode and write a text in it, sending headers
     *
     * @param string $resourceFileName
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return integer
     */
    public static function output(
        string $resourceFileName = "php://output",
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : int {
        //Opening output stream
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


    /**
     * Function middlewaresHandle
     *
     * @param string|array $middlewares
     * @return ResponseInterface
     */
    private function middlewaresHandle($middlewares) : ResponseInterface
    {
        //Route middlewares run
        $response = $this->getResponse();

        foreach (is_string($middlewares) ? explode(",", $middlewares) : $middlewares as $middleware) {
            if (key_exists($middleware, $this->middlewares['route']) &&
            (($response->getStatusCode() >= 200) && $response->getStatusCode() <= 206)) {
                $response = (new $this->middlewares['route'][$middleware])->handle($this->request);
            }
        }

        return $response;
    }

    /**
     * handle function
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        //Mergin Route arguments and ServerRequest data, files, cookies...
        $args = (object) array_merge(
            $this->route !== null ? (array) ($this->route->getArguments() ?? []) : [],
            $request->getServerParams()
        );

        //get callback Closure
        $callback = $this->route->getCallback();
        
        if ($callback instanceof \Closure) {
            try {
                return $this->closure($callback, $args);
            } catch (InvalidArgumentException $e) {
                throw $e;
            }
        }

        //get callback String Controller
        $callback = $this->route->getCallbackString();

        if (preg_match("/[a-zA-Z0-9]{1,}[@|::]{1,}[a-zA-Z0-9]{0,}/", $callback)) {
            try {
                return $this->controller($callback, $args);
            } catch (InvalidArgumentException $e) {
                throw $e;
            }
        }

        return $this->response(500);
    }


    /**
     * Function run
     *
     * @return void
     */
    public function run(string $inputResource = "php://input", string $outputResource = "php://output")
    {
        $this->request->withParsedBody($this->input($inputResource));

        //Before middlewares here
        foreach ($this->middlewares['before'] as $key => $before) {
            if (($this->response->getStatusCode() >= 200) && $this->response->getStatusCode() <= 206) {
                $response = (new $before())->handle($this->request);
                $this->response->withStatus($response->getStatusCode(), $response->getReasonPhrase());
            }
        }

        $this->route = $this->router->getRoute();
        if ($this->route === null) {
            $this->response->withStatus(
                $this->router->getResponse()->getStatusCode(),
                $this->router->getResponse()->getReasonPhrase()
            );
        }

        if ($this->route instanceof Route) {
            if ($this->router->getResponse()->getStatusCode() === 200) {
                //Route middlewares run
                $response = $this->middlewaresHandle($this->route->getMiddlewares());

                //Routing and handle Request
                if (($response->getStatusCode() >= 200) && $response->getStatusCode() <= 206) {
                    $response = $this->handle($this->request);
                }
                $this->response->withStatus($response->getStatusCode(), $response->getReasonPhrase());
            }
        }

        //After middlewares aqui
        foreach ($this->middlewares['after'] as $after) {
            if ($this->response->getStatusCode() < 300) {
                $response = (new $after())->handle($this->request);
                $this->response->withStatus($response->getStatusCode(), $response->getReasonPhrase());
            }
        }

        if ($this->response->getStatusCode() > 206 && $this->response->getBody()->getSize() === null) {
            //todo after middlweare default
            $this->view(
                "error", 
                [
                    "errorMessage" => sprintf("%s | %s",   
                        $this->router->getResponse()->getStatusCode(),
                        $this->router->getResponse()->getReasonPhrase()
                    )
                ]
            );
        }

        return $this->output($outputResource, $this->request, $this->response);
    }
    
}
