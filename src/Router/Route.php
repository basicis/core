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
     * $name variable
     * @var string
     */
    private $name;

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
     * @param string $name - Route name or signature
     * @param string $method - Http method name
     * @param mixed $callback - A function or string corresponding to the name of the controller @ method
     * @param mixed $middlewares - An array or string middlewares list
     */
    public function __construct($name = '/', $method = 'GET', $callback = null, $middlewares = null)
    {
        $this->name = strtolower($name);
        $this->method = strtoupper($method);
        $this->callback = $callback;
        $this->middlewares = $middlewares;
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
    public function setArgument(string $key, $value)
    {
        $this->args[$key] = $value;
        return $this;
    }

    /**
     * Function setArguments
     * @param array $args - Array of arguments
     * @return Route
     */
    public function setArguments(array $args = [])
    {
        $this->args = $args;
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
        return $this->name;
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
