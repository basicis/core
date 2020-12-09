<?php
namespace Basicis\Router;

use Basicis\Core\Validator;
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
     * Function __constructs
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return void
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->url = $request->getUri()->getPath();
        $this->method = strtoupper($request->getMethod());
        $this->routes = [];
    }



    /**
    * Function setRoute
    *
    * @param string $method = "GET"
    * @param string|array $url = "/"
    * @param string|\Clousure $callback = null
    * @param string|array $middlewares = null
    * @return Router
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
     * Function setRouteByAnnotation
     * Receives a class as an argument, and works with the comment blocks as @Route
     *
     * @param string $annotation
     * @param string $callback
     * @return void
     */
    public function setRouteByAnnotation(string $annotation, string $callback)
    {
        $route_array = explode(",", str_replace(array('\'', '"', " ", "@Route(", ")"), '', $annotation));
            
        //url [string|array], method [string|array], callback [string|Closure], middlewares [string|array]
        $this->setRoute($route_array[1], $route_array[0], $callback, $route_array[3] ?? null);
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

        $this->response = ResponseFactory::create(404, "Page or end-point not Found!");
        return null;
    }



    /**
     * Function getRoutes
     *
     * @return array|Route[]
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }



   /**
    * Function hasRoute
    *
    * @param string $name
    * @param string $method
    * @return boolean
    */
    public function hasRoute(string $name, string $method = "GET" ) : bool
    {
        foreach ($this->routes as $route) {
            if (($route->getName() === $name) && ($route->getMethod() === strtoupper($method))) {
                return true;
            }
        }
        return false;
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
        $urlExplode = array_filter(explode('/', $url)) ;
        $routes = null;
        $i = 0;
        $data = [];
        $continue = false;
        $urlStartWith = '';

        foreach ($this->findByMethod($url, $this->findByCount()) as $route_key => $route) {
            $routeNameExplode =  array_filter(explode("/", $route->getName()));

            foreach ($routeNameExplode as $routeNameExplode_key => $routeNameExplodeValue) {
                if (($routeNameExplodeValue === $urlExplode[$routeNameExplode_key])) {
                    $urlStartWith .= '/'.$routeNameExplodeValue;

                    if (($routeNameExplode_key === count($urlExplode)) && ($url === $urlStartWith)) {
                        return [$route];
                    }
                    $continue = true;
                }

                if ($continue) {
                    $arg_regex = $this->extractArgRegex($routeNameExplodeValue);
                    $arg_id = $this->extractArgId($routeNameExplodeValue);

                    if ((($arg_id !== null) && ($arg_regex !== null)) &&
                        Validator::validate($urlExplode[$routeNameExplode_key], $arg_regex)) {
                        $urlStartWith .= '/'.$urlExplode[$routeNameExplode_key];
                        $route->setArgument($arg_id, $urlExplode[$routeNameExplode_key]);
                        
                        if (($routeNameExplode_key === count($urlExplode)) && ($url === $urlStartWith)) {
                            return  [$route];
                        }
                    }
                    continue;
                }

                if (($routeNameExplode_key === count($urlExplode)) && ($url !== $urlStartWith)) {
                    return null;
                }
            }

            $urlStartWith = '';
            $i++;
        }
        
        return null;
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
        $i = 0;
        $return = [];

        if ($routes) {
            foreach ($routes as $route) {
                $routeNameExplode = explode('/', $route->getName());
                $urlExplode = explode('/', $url);
                if ((count(array_filter($routeNameExplode)) === count(array_filter($urlExplode)))) {
                    $return[$i] = $route;
                }
                $i++;
            }
        }

        return $return;
    }



    /**
     * Function extractArgRegex
     *
     * @param string $routeNamePart
     *
     * @return string|null
     */
    public function extractArgRegex(string $routeNamePart = null) : ?string
    {
        $explode = explode('}', $routeNamePart);
        return (count($explode) > 1) ? substr($explode[1], 1) : null;
    }



    /**
     * function extractArgId
     *
     * @param string $routeNamePart
     *
     * @return string|null
     */
    public function extractArgId(string $routeNamePart = null) : ?string
    {
        $explode = explode('}', $routeNamePart);
        return (count($explode) > 1)? str_replace(['{', ':'], '', $explode[0]) : null;
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

        foreach ($url as $urlKey => $urlValue) {
            if (isset($urlValue['url'])) {
                if (is_array($urlValue['url'])) {
                    foreach ($urlValue['url'] as $urlValue_item) {
                        $this->setRoute(
                            $urlValue_item,
                            isset($urlValue['callback']) ? $urlValue['callback'] : $callback,
                            isset($urlValue['middlewares']) ? $urlValue['middlewares'] : $middlewares,
                            isset($urlValue['method']) ?  $urlValue['method'] : 'GET'
                        );
                    }
                } else {
                    $this->setRoute(
                        $urlValue['url'],
                        isset($urlValue['callback']) ? $urlValue['callback'] : $callback,
                        isset($urlValue['middlewares']) ? $urlValue['middlewares'] : $middlewares,
                        isset($urlValue['method']) ?  $urlValue['method'] : 'GET'
                    );
                }
            } elseif (is_string($urlValue)) {
                $this->setRoute($urlValue, $callback, $middlewares, 'GET');
            }
        }

        return $this;
    }
}
