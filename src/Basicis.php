<?php
namespace Basicis;

use Basicis\Core\Log;
use Basicis\Core\Validator;
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
use \Twig\TwigFunction;
use \Dotenv\Dotenv;

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
     * $route variable
     *
     * @var Route
     */
    private $route;


    /**
     * $router variable
     *
     * @var Router
     */
    private $router;



    /**
     * $request variable
     *
     * @var ServerRequest
     */
    private $request;


    /**
     * $response variable
     *
     * @var Response
     */
    private $response;


    /**
    * $response variable
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
     * @param array $args
     * @return Basicis
     */
    public function __construct(ServerRequestInterface $request, array ...$options)
    {
        self::loadEnv();
        $this->setMode($options['mode']);
        $this->setTimezone($options['timezone']);
        $this->setRequest($request);
    }



    /**
     * Function createApp Factory
     *
     * @param ServerRequestInterface $request
     * @param array $args
     * @return Basicis
     */
    public static function createApp(ServerRequestInterface $request = null) : Basicis
    {
        return new Basicis($request ?? ServerRequestFactory::create('GET', '/'));
    }

   

    /**
     * Function setControllers
     *
     * @param array $controllers
     *
     * @return void
     */
    public function setControllers(array $controllers = []) : Basicis
    {
        foreach ($controllers as $key => $value) {
            if (!is_string($key) || !class_exists($value) | !(new $value() instanceof Controller)) {
                throw new InvalidArgumentException("Unidentified key or class Basicis\Controller\Controller instance.");
                unset($controllers[$key]);
            }
        }
        $this->controllers = $controllers;
        return $this;
    }



    /**
     * Function getController
     *
     * @param string $key
     *
     * @return Controller|null
     */
    public function getController(string $key) : ?Controller
    {
        if (key_exists($key, $this->controllers)) {
            return new $this->controllers[$key]();
        }
        throw new InvalidArgumentException("Unidentified key for Basicis\Controller\Controller instance.");
        return null;
    }



    /**
     * Function filterMiddlewares
     *
     * @param array $middlewares
     *
     * @return array
     */
    private function filterMiddlewares(array $middlewares = []) : array
    {
        foreach ($middlewares as $key => $middleware) {
            if (!is_string($key) && (new $middleware() instanceof Middleware)) {
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
            $this->middlewares['route'] = $this->filterMiddlewares($middlewares);
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
     * Function path
     * Return app project root path
     * @return string
     */
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
    public static function logger() : Log
    {
        return new Log(self::path());
    }



    /**
     * Function env
     *
     * @param string $name
     * @return void
     */
    public static function loadEnv()
    {
        $env = Dotenv::createImmutable(self::path());
        $env->load();
    }

     /**
     * Function env
     *
     * @param string $name
     * @return string|null
     */
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
    public static function validate($data, $validations, $class = '') : bool
    {
        $validator = new Validator($class);
        if (is_array($data) && is_array($validations)) {
            return $validator->validArray($data, $validations);
        } elseif (is_string((string) $data) && is_string((string) $validations)) {
            return $validator->validString($data, $validations);
        } else {
            return false;
        }
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
        if (in_array($mode, ["production", "prod"])) {
            putenv("APP_ENV=production");
            ini_set('display_errors', 0);
            $this->mode = "production";
            return $this;
        }

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        putenv("APP_ENV=dev");
        $this->mode = "dev";
        return $this;
    }


    /**
     * Function setTimezone
     *
     * @param string $timezone
     *
     * @return Basicis
     */
    public function setTimezone(string $timezone = null) : Basicis
    {
        date_default_timezone_set(isset($timezone) ? $timezone : "America/Recife");
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
        $this->router = RouterFactory::create($request, self::path()."src/");
        $this->request = $request;
        return $this;
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
     *
     * @return ResponseInterface
     */
    public function getResponse(int $code = null) : ResponseInterface
    {
        if ($this->response instanceof ResponseInterface) {
            return ($code !== null) ? $this->response->withStatus($code) : $this->response;
        }
        
        return $this->response = ResponseFactory::create(($code !== null) ? $code : 200);
    }


    /**
     * Function response
     * Alias for getResponse
     *
     * @return ResponseInterface
     */
    public function response(int $code = null) : ResponseInterface
    {
        return $this->getResponse($code);
    }


    /**
     * Function getRouter
     *
     * @return \Basicis\Router\Router
     */
    public function getRouter() : Router
    {
        return $this->router;
    }


    /**
     * Function getRoute
     *
     * @return \Basicis\Router\Route|null
     */
    public function getRoute() : ?Route
    {
        return $this->route;
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
        $this->view = $text;
        return $this->response()->withStatus($statusCode ?? $this->response()->getStatusCode());
    }



    /**
     * Function json
     *
     * @param array $data
     * @param int $statusCode default=200
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
     *
     * @return ResponseInterface
     */
    public function view(string $name, array $data = [], int $statusCode = 200) : ResponseInterface
    {
        $view = new View(self::path() . "src/views/");
        $view->setFilters($this->viewFilters);
        $this->response()->withHeader("Content-Type", ["text/html", "charset=UTF-8"])
                         ->withStatus($statusCode);

        $content = $view->getView($name, $data);
        if ($content !== null) {
            return $this->write($content);
        }
        return $this->write("", 404); //temp
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
            $file = StreamFactory::createStreamFromFile($filename, "r+");

            if ($file->isReadable()) {
                return $this->response()
                    ->withHeaders(
                        [
                            "Content-Type" => [mime_content_type($filename)],
                            "Content-disposition" => ["attachment", "filename=".basename($filename)]
                        ]
                    )
                    ->withBody($file)
                    ->withStatus(200, "File is found oK!");
            }

            return $this->response()->withStatus(404, "File not found!");
        }

        return $this->response()->withStatus(500, "Development error, Filename must not be null.");
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
     * @param string $resourceFileName = "php://output"
     * @return void
     */
    public static function input(string $resourceFileName = "php://input"): string
    {
        //Opening output stream
        $stream = (new StreamFactory())->createStreamFromFile($resourceFileName, 'r');
        $content = $stream->getContents();
        $stream->close();
        return $content ?? '';
    }


    /**
     * Function output
     * Open a Stream Resource in Recording mode and write a text in it, sending headers
     *
     * @param string $$body
     * @param  string $resourceFileName = "php://output"
     *
     * @return int
     */
    public static function output(
        ServerRequestInterface $request,
        ResponseInterface $response,
        string $resourceFileName = "php://output"
    ) : int {
        //Opening output stream
        $stream = (new StreamFactory())->createStreamFromFile($resourceFileName, 'rw');
        $size = 0;
    
        if ($stream->isWritable()) {
            @header(
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
                @header($response->getHeaderLine($name), true);
            }
            $size = $stream->write($response->getBody());
            $response->getBody()->close();
        }

        $stream->close();
        return $size;
    }



    /**
     * handle function
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //Mergin Route arguments and ServerRequest data, files, cookies...
        $args = (object) array_merge(
            $this->route !== null ? (array) ($this->route->getArguments() ?? []) : [],
            [],
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
    public function run() : ResponseInterface
    {
        $this->response = $this->response()->withHeader("X-Powered-By", "Basicis Framework");

        //Before middlewares here
        foreach ($this->middlewares['before'] as $key => $before) {
            if (($this->response->getStatusCode() >= 200) && $this->response->getStatusCode() <= 206) {
                $this->response = (new $before())->handle($this->request);
            }
        }

        //Routing and handle Request
        $router = RouterFactory::create($this->request, self::path()."src/");
        $this->route = $router->getRoute();

        if ($this->route instanceof Route) {
            if ($router->getResponse()->getStatusCode() === 200) {
                //Route middlewares run
                $middlewares = $this->route->getMiddlewares();
                foreach (is_string($middlewares) ? explode(",", $middlewares) : $middlewares as $middleware) {
                    if (key_exists($middleware, $this->middlewares['route']) &&
                    (($this->response->getStatusCode() >= 200) && $this->response->getStatusCode() <= 206)) {
                        $this->response = (new $this->middlewares['route'][$middleware])->handle($this->request);
                    }
                }

                //Routing and handle Request
                if (($this->response->getStatusCode() >= 200) && $this->response->getStatusCode() <= 206) {
                    $this->response = $this->handle($this->request);
                }
            }
        } else {
            $this->response = $router->getResponse();
        }

        //After middlewares aqui
        foreach ($this->middlewares['after'] as $after) {
            if ($this->response->getStatusCode() < 300) {
                $this->response = (new $after())->handle($this->request);
            }
        }
        
        //Sending body to client
        //return $this->output($this->view);
        return $this->response;
    }
}
