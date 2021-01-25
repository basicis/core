<?php
namespace Basicis\Http\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Basicis\Http\Server\RequestHandler;
use Basicis\Basicis as App;

/**
 * PipeLine class
 * Handles a server request and produces a response.
 * An HTTP request handler process an HTTP request in order to produce an
 * HTTP response.
 *
 * @category Basicis/Http/Server
 * @package  Basicis/Http/Server
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Server/Middleware.php
 */
class PipeLine extends RequestHandler
{
    /**
     * $pipeLine variable
     *
     * @var array
     */
    protected $pipeLine = [];

    /**
    * Function __invoke
    * Handles a request and produces a response.
    * May call other collaborating code to generate the response.
    *
    * @param ServerRequestInterface $request
    * @param ResponseInterface $response
    * @param callable $next null
    * @return ResponseInterface
    */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) : ResponseInterface {
        return $this->handle($request, $response, $next);
    }

    /**
    * Function handle
    * Handles a request and produces a response.
    * May call other collaborating code to generate the response.
    *
    * @param ServerRequestInterface $request
    * @param ResponseInterface $response
    * @param callable $next null
    * @return ResponseInterface
    */
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) : ResponseInterface {
        //Handle all pipeline
        foreach ($this->pipeLine as $i => $line) {
            $response = $line($request, $response);
        }

        if ($next === null) {
            return $response;
        }
        return $next($request, $response);
    }

    /**
     * Function add
     * Add a action to end of pipeline
     * @param $next
     *
     * @return PipeLine
     */
    public function add($next) : PipeLine
    {
        $this->pipeLine[] = $next;
        return $this;
    }

    /**
     * Function add
     * Add a action to start of pipeline
     * @param callabe $next
     *
     * @return PipeLine
     */
    public function addFirst(callabe $next) : PipeLine
    {
        $this->pipeLine = array_unshift($this->pipeLine, $next);
        return $this;
    }

    /**
     * Function reset
     * Reset this pipeline
     * @return PipeLine
     */
    public function reset() : PipeLine
    {
        $this->pipeLine = [];
        return $this;
    }

    /**
     * Function removed
     * Remove pipeline item by index
     * @return PipeLine
     */
    public function remove(int $index) : PipeLine
    {
        $this->pipeLine = array_splice($this->pipeLine, $index, 1);
        return $this;
    }

    /**
     * Function removeFromIndexToEnd
     * Remove pipeline item by index
     * @return PipeLine
     */
    public function removeFromIndexToEnd(int $index) : PipeLine
    {
        $this->pipeLine = array_splice($this->pipeLine, $index);
        return $this;
    }

    /**
     * Function get
     * Get all lines from array
     * @return array
     */
    public function get() : array
    {
        return $this->pipeLine;
    }
}
