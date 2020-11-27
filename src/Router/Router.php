<?php
namespace Basicis\Router;

use Basicis\Basicis as App;
use Basicis\Http\Message\ResponseFactory;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Basicis\Exceptions\BasicisException;
use Basicis\Exceptions\InvalidArgumentException;

/**
 * Router Class
 * @category Basicis/Router
 * @package  Basicis/Router
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Router/Router.php
 */
class Router
{
    /**
     * $routes variable
    *
     * @var array
     */
    private $routes;



    /**
     * $method variable
     *
     * @var string
     */
    private $method;



    /**
     * $path variable
     *
     * @var string
     */
    private $path;

    
    /**
     * $response variable
     *
     * @var ResponseInterface
     */
    private $response;


    /**
     * $filesIsLoaded variable
     *
     * @var bool
     */
    private $filesIsLoaded = false;
    

    /**
     * Function __constructs
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param string $path
     * @return void
     */
    public function __construct(ServerRequestInterface $request, string $path = ".")
    {
        $this->path = $path;
        $this->url = $request->getRequestTarget();
        $this->method = strtoupper($request->getMethod());
        $this->routes = [];
        $this->loadFiles();
    }



    /**
    * Function setRoute
    *
    * @param string $method = "GET"
    * @param string|array $url = "/"
    * @param string|\Clousure $callback = null
    * @param string|array $middlewares = null
    * @return boolean
    */
    public function setRoute(string $method = "GET", $url = "/", $callback = null, $middlewares = null) : Router
    {
        if (is_array($url)) {
            foreach ($url as $url_as) {
                array_push($this->routes, new Route($url_as, $method, $callback, $middlewares));
            }
        } elseif (is_string($url)) {
            array_push($this->routes, new Route($url, $method, $callback, $middlewares));
        }
        return $this;
    }



    /**
     * Function getRoute
     *
     * @param string $url
     * @param string $method = 'GET'
     * @return Route|null
     */
    public function getRoute() : ?Route
    {
        $routes = $this->findByRegex($this->url);
        $routes = $routes ? $routes : $this->findByName($this->url);

        if ($routes &&  (count($routes) == 1)) {
            $this->response = ResponseFactory::create(200);
            return $routes[0];
        }

        if ($routes && (count($routes) > 1)) {
            $this->response = ResponseFactory::create(500, sprintf(
                'Replicate routes, %s Routes with the same name or signature for %s.',
                count($routes),
                $this->url
            ));

            return null;
        }

        if ($this->filesIsLoaded) {
            $this->response = ResponseFactory::create(404, "Page or end-point not Found.");
            return null;
        }

        if ($this->response === null && !$this->filesIsLoaded) {
            $this->response = ResponseFactory::create(500, "Route files no is loaded!");
        }
        return null;
    }


    /**
     * Function getRoutes
     *
     * @return array|Route[]
     */
    public function getRoutes() : array
    {
        return $this->routes();
    }


    /**
     * Function getResponse
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getResponse() : ResponseInterface
    {
        return ($this->response instanceof ResponseInterface) ? $this->response : ResponseFactory::create(404);
    }

    
    /**
     * Function findByRegex
     *
     * @param string $url
     * @return array|null
     */
    public function findByRegex(string $url = null) : ?array
    {
        $url = is_null($url) ? $this->url : $url;
        $url_exp = array_filter(explode('/', $url)) ;
        $routes=null;
        $i = 0;
        $data=[];
        $continue = false;
        $url_start_with = '';

        foreach ($this->findByMethod($url, $this->findByCount()) as $route_key => $route) {
            $route_name_exp =  array_filter(explode("/", $route->getName()));

            foreach ($route_name_exp as $route_name_exp_key => $route_name_exp_value) {
                if (($route_name_exp_value === $url_exp[$route_name_exp_key])) {
                    $url_start_with .= '/'.$route_name_exp_value;

                    if (($route_name_exp_key === count($url_exp)) && ($url === $url_start_with)) {
                        return [$route];
                    }
                    $continue = true;
                }

                if ($continue) {
                    $arg_regex = $this->extractArgRegex($route_name_exp_value);
                    $arg_id = $this->extractArgId($route_name_exp_value);

                    if ((($arg_id !== null) && ($arg_regex !== null)) &&
                        App::validate($url_exp[$route_name_exp_key], $arg_regex)) {
                        $url_start_with .= '/'.$url_exp[$route_name_exp_key];
                        $route->setArgument($arg_id, $url_exp[$route_name_exp_key]);
                        
                        if (($route_name_exp_key === count($url_exp)) && ($url === $url_start_with)) {
                            return  [$route];
                        }
                    }
                    continue;
                }

                if (($route_name_exp_key === count($url_exp)) && ($url !== $url_start_with)) {
                    return null;
                }
            }

            $url_start_with = '';
            $i++;
        }
        
        return null;
    }


    /**
     * Function extractArgRegex
     *
     * @param string $route_name_part
     *
     * @return string|null
     */
    public function extractArgRegex(string $route_name_part = null) : ?string
    {
        $explode = explode('}', $route_name_part);
        return (count($explode) > 1) ? substr($explode[1], 1) : null;
    }

    /**
     * function extractArgId
     *
     * @param string $route_name_part
     *
     * @return string|null
     */
    public function extractArgId(string $route_name_part = null) : ?string
    {
        $explode = explode('}', $route_name_part);
        return (count($explode) > 1)? str_replace(['{', ':'], '', $explode[0]) : null;
    }


    /**
     * Function findByName
     *
     * @param string $url
     * @return Array
     */
    public function findByName(string $url = null) : array
    {
        $url = is_null($url) ? $this->url : $url;
        
        if ((strlen($url)>1) && (strripos($url, '/') == (strlen($url)-1))) {
            $url = substr($url, 0, strlen($url)-1);
        }

        $routes = [];
        $i = 0;

        foreach ($this->findByMethod($url, $this->findByCount()) as $route) {
            if (((count(array_filter(explode('/', $url))) == count(array_filter(explode('/', $route->getName())))) &&
            ($this->method === $route->getMethod() )) && ($url == $route->getName())
            ) {
                $routes[$i] = $route;
                $i++;
            }
        }
        return $routes;
    }


    /**
     * Function findByMethod
     *
     * @param string $url
     * @param array $routes
     * @return array
     */
    public function findByMethod(string $url = null, array $routes = null) : array
    {
        $routes = is_null($routes) ? (array) $this->routes : $routes;
        $i=0;
        $return = [];

        if ($routes) {
            foreach ($routes as $route) {
                if ($route->getMethod() === $this->method) {
                    $return[$i] = $route;
                }
                $i++;
            }
        }

        return $return;
    }



    /**
     * Function findByCount
     *
     * @param string $url
     * @param array $routes
     * @return Route[]
     */
    public function findByCount(string $url = null, array $routes = null) : array
    {
        $url = preg_replace('/^\/\s*/', '', is_null($url) ? $this->url : $url);
        $routes = is_null($routes) ? $this->routes : $routes;
        $i=0;
        $return = [];

        if ($routes) {
            foreach ($routes as $route) {
                $route_name_explode = explode('/', $route->getName());
                $url_explode = explode('/', $url);
                if ((count(array_filter($route_name_explode)) === count(array_filter($url_explode)))) {
                    $return[$i] = $route;
                }
                $i++;
            }
        }

        return $return;
    }



    /**
     * Funtion loadFiles
     *
     * @return void
     */
    public function loadFiles() : void
    {
        foreach (glob($this->path.'/[R,r][oute]*s/*.php') as $route_file) {
            if (file_exists($route_file)) {
                try {
                    include $route_file;
                } catch (BasicisException $exception) {
                    $this->filesIsLoaded = false;
                    $msg = splitf("Erro while load file %s.", $route_file);
                    $this->response = ResponseFactory::create(500, $msg);
                    throw new BasicisException($msg, 0, $exception);
                    break;
                }
            }
        }

        if (count($this->routes) >= 1) {
            $this->filesIsLoaded = true;
        }
        return;
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
        $this->setRoute('GET', $url, $callback, $middlewares);
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
        $this->setRoute('POST', $url, $callback, $middlewares);
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
        $this->setRoute('PUT', $url, $callback, $middlewares);
    }



    /**
     * Function path
     *
     * @param string $url
     * @param string|\Closure $callback
     * @param string|array $middlewares
     * @return void
     */
    public function path(string $url, $callback = null, $middlewares = null)
    {
        $this->setRoute('PATCH', $url, $callback, $middlewares);
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
        $this->setRoute('DELETE', $url, $callback, $middlewares);
    }



    /**
     * group function alias for routerGroup
     *
     * @param array $url
     * @param string|\Closure $callback
     * @param string|array $middlewares
     * @return void
     */
    public function group(array $url, object $callback = null, $middlewares = null)
    {
        $this->routerGroup($url, $callback, $middlewares);
    }

    /**
     * routerGroup function
     *
     * @param array $url
     * @param string|\Closure $callback
     * @param string|array $middlewares
     * @throws InvalidArgumentException for invalid callback is null
     * @return void
     */
    private function routerGroup(array $url, $callback = null, $middlewares = null)
    {
        if (is_null($callback)) {
            throw new InvalidArgumentException("Invalid callback is null");
            return $this;
        }

        foreach ($url as $url_key => $url_value) {
            if (isset($url_value['url'])) {
                if (is_array($url_value['url'])) {
                    foreach ($url_value['url'] as $url_value_item) {
                        $this->setRoute(
                            $url_value_item,
                            isset($url_value['callback']) ? $url_value['callback'] : $callback,
                            isset($url_value['middlewares']) ? $url_value['middlewares'] : $middlewares,
                            isset($url_value['method']) ?  $url_value['method'] : 'GET'
                        );
                    }
                } else {
                    $this->setRoute(
                        $url_value['url'],
                        isset($url_value['callback']) ? $url_value['callback'] : $callback,
                        isset($url_value['middlewares']) ? $url_value['middlewares'] : $middlewares,
                        isset($url_value['method']) ?  $url_value['method'] : 'GET'
                    );
                }
            } elseif (is_string($url_value)) {
                $this->setRoute($url_value, $callback, $middlewares, 'GET');
            }
        }
        return $this;
    }
}
