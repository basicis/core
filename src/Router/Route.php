<?php
namespace Basicis\Router;

use Basicis\Basicis as App;

/**
 * Route Class
 *
 * @category Basicis/Router
 * @package  Basicis/Router
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Router/Route.php
 * [@Annotation]
 */
class Route
{
    /**
     * $url variable
     * @var string
     */
    private $url;

    /**
     * $method variable
     * @var string
     */
    private $method;

    /**
     * $args variable
     * @var string
     */
    private $args;

    /**
     * $name middlewares
     * @var mixed
     */
    private $middlewares;

    /**
     * $name middlewares
     * @var mixed
     */
    private $callback;

    /** Function __construct
     * @param string $url - Route url or signature
     * @param string $method - Http method url
     * @param mixed $callback - A function or string corresponding to the url of the controller @ method
     * @param mixed $middlewares - An array or string middlewares list
     */
    public function __construct($url = '/', $method = 'GET', $callback = null, $middlewares = null)
    {
        $this->url = strtolower($url);
        $this->method = strtoupper($method);
        $this->callback = $callback;
        
        if (is_string($middlewares) && count(explode(",", $middlewares)) >= 2) {
            $this->middlewares = explode(",", $middlewares);
            return;
        }

        if (is_array($middlewares)) {
            $this->middlewares = $middlewares;
            return;
        }

        if ($middlewares === null) {
            $this->middlewares =  ["guest"];
            return;
        }
    }

    /**
     * Function getCallback
     * @return \Closure|null
     */
    public function getCallback() : ?\Closure
    {
        return !is_string($this->callback) ? $this->callback : null;
    }


    /**
    * Function getCallbackString
    * @return string|null
    */
    public function getCallbackString() : ?string
    {
        return is_string($this->callback) ? $this->callback : null;
    }

    /**
     * Function setCallback
     * @return Route
     */
    public function setCallback($callback = null) : Route
    {
        if ($callback !== null) {
            $this->callback = $callback;
        }
        return $this;
    }

    /**
     * Function setArgument
     * @param string $key - key of argument object
     * @param mixed $value - value to this key
     * @return Route
     */
    public function setArgument(string $key, $value) : Route
    {
        if (!empty($key) && strlen($key) >= 2) {
            $this->args[$key] = urldecode($value);
        }
        return $this;
    }

    /**
     * Function setArguments
     * @param array $args - Array of arguments
     * @return Route
     */
    public function setArguments(array $args = []) : Route
    {
        foreach ($args as $key => $value) {
            $this->setArgument($key, $value);
        }
        return $this;
    }

    /**
     * Function getArguments
     * @return object|null
     */
    public function getArguments() : ?object
    {
        return (object) $this->args ?? null;
    }

    /**
     * Function getName
     * @return string
     */
    public function getName() : string
    {
        return $this->url;
    }

    /**
     * Function getMethod
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * Function getMiddlewares
     * @return array
     */
    public function getMiddlewares() : array
    {
        if ($this->middlewares === null) {
            return [];
        }
        return is_string($this->middlewares) ? explode(',', strtolower($this->middlewares)) : $this->middlewares;
    }
}
